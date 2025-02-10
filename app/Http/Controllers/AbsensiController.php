<?php
namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $absensi        = Absensi::where('id_user', Auth::id())->get();
        $izinSakit      = Absensi::where('status', 'sakit')->get();
        $izinSakitCount = $izinSakit->count();

        $pegawai = User::all();

        return view('user.absensi.index', compact('absensi', 'pegawai', 'izinSakit', 'izinSakitCount'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $absensi = Absensi::all();
        $pegawai = User::where('is_admin', 0)->get();
        return view('user.absensi.index', compact('absensi', 'pegawai'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $request->validate([
            'id_user' => 'required|exists:users,id',
        ]);

        $currentTime = Carbon::now('Asia/Jakarta');

        $pegawai = User::find($request->id_user);
        if (! $pegawai) {
            return redirect()->route('absensi.index')->with('error', 'User tidak ditemukan!');
        }

        $sudahAbsen = Absensi::where('id_user', $pegawai->id)
            ->whereDate('created_at', Carbon::today('Asia/Jakarta'))
            ->first();

        if ($sudahAbsen) {
            return redirect()->route('absensi.index')->with('error', 'Anda telah melakukan Absen Hari Ini!');
        }

        $note         = null;
        $status       = 'Hadir';                                         // Default status adalah Hadir
        $latenessTime = Carbon::createFromTime(8, 0, 0, 'Asia/Jakarta'); // Waktu batas telat

        if ($currentTime->greaterThan($latenessTime)) {
            $diffInMinutes = $latenessTime->diffInMinutes($currentTime);

                                                   // Menghitung jam dan menit
            $hours   = floor($diffInMinutes / 60); // Jam
            $minutes = $diffInMinutes % 60;        // Sisa menit setelah jam dihitung

            // Menampilkan hasil dalam format "Telat X jam Y menit"
            if ($hours > 0) {
                $note = "Telat $hours jam $minutes menit";
            } else {
                $note = "Telat $minutes menit";
            }

            $status = 'Telat'; // Jika telat, status diubah jadi 'Telat'
        } else {
            $note = "Hadir tepat waktu"; // Jika tidak telat, catatan "Hadir tepat waktu"
        }

        // Menyimpan data absensi
        Absensi::create([
            'id_user'       => $request->id_user,
            'tanggal_absen' => $currentTime->toDateString(),
            'jam_masuk'     => $currentTime->toTimeString(),
            'note'          => $note,
            'status'        => $status, // Menyimpan status (Hadir atau Telat)
        ]);

        return redirect()->route('absensi.index')->with('success', 'Absen Masuk berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta'); // Set time zone
        $currentTime = Carbon::now('Asia/Jakarta');
        $today       = Carbon::today('Asia/Jakarta')->format('Y-m-d');

        // Retrieve today's attendance record for the given user
        $absensi = Absensi::where('id_user', Auth::user()->id)
            ->where('tanggal_absen', $today)
            ->first();

        if (! $absensi) {
            return redirect()->back()->with('error', 'Data absensi tidak ditemukan untuk hari ini.');
        }

        // Check if it's the correct time to perform check-out
        // if ($currentTime->between(Carbon::createFromTime(15, 0, 0), Carbon::createFromTime(16, 0, 0))) {
        // Update only if `jam_keluar` is not already set
        if (is_null($absensi->jam_keluar)) {
            $absensi->jam_keluar = $currentTime->toTimeString();
            $absensi->save();

            return redirect()->back()->with('success', 'Absen pulang berhasil disimpan!');
        } else {
            return redirect()->back()->with('error', 'Anda sudah melakukan absen pulang hari ini.');
        }
        // } else {
        //     return redirect()->back()->with('error', 'Absen pulang hanya bisa dilakukan antara 15:00 dan 16:00.');
        // }
    }

    public function absenSakit(Request $request)
    {
        $id_user       = Auth::user()->id;
        $tanggal_absen = \Carbon\Carbon::today('Asia/Jakarta')->format('Y-m-d');

        // Cek apakah sudah ada absen di tanggal ini
        $absensi = Absensi::where('id_user', $id_user)->where('tanggal_absen', $tanggal_absen)->first();

        if ($absensi) {
            return redirect()->back()->with('error', 'Anda sudah absen hari ini');
        }

        // Simpan absen sakit
        $absensi                = new Absensi();
        $absensi->id_user       = $id_user;
        $absensi->tanggal_absen = $tanggal_absen;
        $absensi->jam_keluar    = null;
        $absensi->note          = 'Sakit';
        $absensi->status        = 'Sakit';

        if ($request->hasFile('photo')) {
            $file           = $request->file('photo');
            $filePath       = $file->store('photo', 'public');
            $absensi->photo = $filePath;
        }

        $absensi->save();

        return redirect()->back()->with('success', 'Absen sakit berhasil disimpan');
    }

    public function izinSakit(Request $request)
    {
        $pegawai = User::all();
        $absensi = Absensi::all();

        // Mengambil data absensi dengan status 'sakit', diurutkan secara descending berdasarkan tanggal
        $izinSakit = Absensi::where('status', 'Sakit')
            ->orderBy('created_at', 'desc')
            ->get();

        // Menghitung jumlah izin sakit yang belum ada
        $izinSakitCount = Absensi::where('status', 'Sakit')->count();

        // Menyimpan status "viewed" di session untuk setiap izin sakit yang telah dilihat
        $viewedPhotos = [];
        foreach ($izinSakit as $data) {
            $viewedPhotos[$data->id] = session()->has("viewed_{$data->id}");
        }
        session(['izinSakitCount' => 0]);

        // Mengirim data izin sakit, count, absensi, pegawai, dan status foto ke view
        return view('admin.izin.sakit', compact('izinSakit', 'izinSakitCount', 'absensi', 'pegawai', 'viewedPhotos'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function absensiUpdateStatus(Request $request)
    {
        $absensi_id      = $request->input('absensi_id');
        $absensi         = Absensi::findOrFail($absensi_id);
        $absensi->viewed = true;
        $absensi->save();

        $newCount = Absensi::where('status', 'Sakit')->where('viewed', false)->count();

        return response()->json([
            'message'   => 'Status updated',
            'new_count' => $newCount,
        ]);
    }
}

@extends('layout.template')

@section('main')
    <div class="card">
        <div class="card-header">
            <h1 class="text-center">Rekap Sidang</h1>
        </div>
    </div>
    <table class="table table-bordered border-primary">
        <tbody>
            @if ($sidang->tugasAkhir)
                <tr>
                    <th>Judul Tugas Akhir:</th>
                    <td>
                        {{ $sidang->tugasAkhir ? $sidang->tugasAkhir->Judul : 'Judul tidak tersedia' }}
                    </td>
                </tr>
                <tr>
                    <th>Nama Mahasiswa:</th>
                    <td>{{ $sidang->tugasAkhir->mahasiswa }}</td>
                </tr>
                <tr>
                    <th>Dosen Pembimbing 1:</th>
                    <td>{{ $sidang->tugasAkhir->pembimbing1 }}</td>
                </tr>
                <tr>
                    <th>Dosen Pembimbing 2:</th>
                    <td>{{ $sidang->tugasAkhir->pembimbing2 }}</td>
                </tr>
                <tr>
                    <th>Ruangan:</th>
                    <td>{{ $sidang->ruangan->nama }}</td>
                </tr>
                <tr>
                    <th>Tanggal sidang</th>
                    <td>{{ $sidang->tanggal }}</td>
                </tr>
            @endif
        </tbody>
    </table>
    <div class="card">
        <div class="card-header">
            <h1 class="text-center">Rekap Penilaian</h1>
        </div>
    </div>
    <table class="table table-bordered border-primary">
        <th>Jabatan</th>
        <th>Nama</th>
        <th>Total Nilai</th>
        <th>Komentar</th>
        <tbody>

            @if ($penilaianpembimbing1)
                <tr>
                    <td>Pembimbing 1</td>
                    <td>{{ $penilaianpembimbing1->dosenpenguji->nama }}</td>
                    <td>{{ $penilaianpembimbing1->nilai }}</td>
                    <td>{{ $penilaianpembimbing1->komentar }}</td>
                </tr>
            @else
                <tr>
                    <td>Pembimbing 1</td>
                    <td colspan="4">Data penilaian untuk Pembimbing 1 tidak tersedia.</td>
                </tr>
            @endif

            @if ($penilaianpembimbing2)
                <tr>
                    <td>Pembimbing 2</td>
                    <td>{{ $penilaianpembimbing2->dosenpenguji->nama }}</td>
                    <td>{{ $penilaianpembimbing2->nilai }}</td>
                    <td>{{ $penilaianpembimbing2->komentar }}</td>
                </tr>
            @else
                <tr>
                    <td>Pembimbing 2</td>
                    <td colspan="4">Data penilaian untuk Pembimbing 2 tidak tersedia.</td>
                </tr>
            @endif
            @if ($ratapendidikan !== null)
                <tr>
                    <td>Rata-rata Pendidikan</td>
                    <td colspan="4">{{ $ratapendidikan }}</td>
                </tr>
            @else
                <tr>
                    <td>Rata-rata Pendidikan</td>
                    <td colspan="5">Rata-rata Pendidikan belum tersedia.</td>
                </tr>
            @endif
            @if ($penilaianketuasidang)
                <tr>
                    <td>Ketua Sidang</td>
                    <td>{{ $penilaianketuasidang->dosenpenguji->nama }}</td>
                    <td>{{ $penilaianketuasidang->nilai }}</td>
                    <td>{{ $penilaianketuasidang->komentar }}</td>
                </tr>
            @else
                <tr>
                    <td>Ketua Sidang</td>
                    <td colspan="4" class="text-center">Data penilaian untuk Ketua Sidang tidak tersedia.</td>
                </tr>
            @endif

            @if ($penilaiansekretarissidang)
                <tr>
                    <td>Sekretaris Sidang</td>
                    <td>{{ $penilaiansekretarissidang->dosenpenguji->nama }}</td>
                    <td>{{ $penilaiansekretarissidang->nilai }}</td>
                    <td>{{ $penilaiansekretarissidang->komentar }}</td>
                </tr>
            @else
                <tr>
                    <td>Sekretaris Sidang</td>
                    <td colspan="4">Data penilaian untuk Sekretaris Sidang tidak tersedia.</td>
                </tr>
            @endif
            @if ($penilaianpenguji1)
                <tr>
                    <td>Penguji 1</td>
                    <td>{{ $penilaianpenguji1->dosenpenguji->nama }}</td>
                    <td>{{ $penilaianpenguji1->nilai }}</td>
                    <td>{{ $penilaianpenguji1->komentar }}</td>
                </tr>
            @else
                <tr>
                    <td>Penguji 1</td>
                    <td colspan="4">Data penilaian untuk Penguji 1 tidak tersedia.</td>
                </tr>
            @endif

            @if ($penilaianpenguji2)
                <tr>
                    <td>Penguji 2</td>
                    <td>{{ $penilaianpenguji2->dosenpenguji->nama }}</td>
                    <td>{{ $penilaianpenguji2->nilai }}</td>
                    <td>{{ $penilaianpenguji2->komentar }}</td>
                </tr>
            @else
                <tr>
                    <td>Penguji 2</td>
                    <td colspan="4">Data penilaian untuk Penguji 2 tidak tersedia.</td>
                </tr>
            @endif
            @if ($ratapenguji !== null)
                <tr>
                    <td>Rata-rata Penguji</td>
                    <td colspan="5">{{ $ratapenguji }}</td>
                </tr>
            @else
                <tr>
                    <td>Rata-rata Penguji</td>
                    <td colspan="5">Rata-rata Penguji belum tersedia.</td>
                </tr>
            @endif

            @if ($rataRata !== null)
                <tr>
                    <td>Nilai Akhir</td>
                    <td colspan="5">{{ $rataRata }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td colspan="4">{{ $rataRata >= 65 ? 'Lulus' : 'Tidak Lulus' }}</td>
                </tr>
            @else
                <tr>
                    <td>Nilai Akhir</td>
                    <td colspan="5">Nilai Akhir belum tersedia.</td>
                </tr>
            @endif
        </tbody>


    </table>


    <button class="btn btn-primary mt-3 mb-3" onclick="window.print()">Cetak Berita Acara Sidang</button>


    <a href="{{ route('sidang.index') }}" class="btn btn-primary mt-3 mb-3">Kembali</a>
@endsection

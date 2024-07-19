@extends('layout.template')

@section('main')
    <div class="card">
        <div class="card-header">
            <h1 class="text-center">Penilaian</h1>
        </div>
    </div>
    <table class="table table-bordered border-primary">
        <th>No</th>
        <th>Jabatan</th>
        <th>Nama</th>
        <th>Total Nilai</th>
        <th>Komentar</th>
        <tbody>

            @if ($penilaianpembimbing1)
                <tr>
                    <td>1</td>
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
                    <td>2</td>
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
                    <td colspan="4">Rata-rata Pendidikan belum tersedia.</td>
                </tr>
            @endif
            @if ($penilaianketuasidang)
                <tr>
                    <td>4</td>
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
                    <td>5</td>
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
                    <td>6</td>
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
                    <td>7</td>
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
                    <td colspan="4">{{ $ratapenguji }}</td>
                </tr>
            @else
                <tr>
                    <td>Rata-rata Penguji</td>
                    <td colspan="4">Rata-rata Penguji belum tersedia.</td>
                </tr>
            @endif

            @if ($rataRata !== null)
                <tr>
                    <td>Nilai Akhir</td>
                    <td colspan="4">{{ $rataRata }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td colspan="4">{{ $rataRata >= 65 ? 'Lulus' : 'Tidak Lulus' }}</td>
                </tr>
            @else
                <tr>
                    <td>Nilai Akhir</td>
                    <td colspan="4">Nilai Akhir belum tersedia.</td>
                </tr>
            @endif
        </tbody>


    </table>
@endsection

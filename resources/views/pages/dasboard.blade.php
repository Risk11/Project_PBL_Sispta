@extends('layout.template')

@section('main')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Informasi TA dan Jurusan Teknologi Informasi</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body {
                background-color: #f8f9fc;
                font-family: Arial, sans-serif;
            }

            .header {
                text-align: center;
                margin-bottom: 50px;
            }

            .header h1 {
                font-size: 3rem;
                color: #fcfcfc;
            }

            .container {
                background-image: url('0313.jpg');
                background-size: cover;
                background-position: center;
                padding: 50px;
                border-radius: 15px;
                margin-bottom: 20px;
            }

            .info-box {
                background-color: rgba(255, 255, 255, 0.8);
                border-radius: 10px;
                box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
                padding: 30px;
                margin-bottom: 30px;
                position: relative;
                overflow: hidden;
            }

            .info-box::before {
                content: '';
                position: absolute;
                top: -100px;
                left: 0;
                width: 100%;
                height: 200px;
                opacity: 0.5;
                background-color: #a7e0fa;
                transition: top 0.5s ease-in-out;
            }

            .info-box:hover::before {
                top: 0;
            }

            .info-box h2 {
                margin-top: 0;
                color: #fff;
                transition: color 0.5s ease-in-out;
            }

            .info-box:hover h2 {
                color: #343a40;
            }

            .info-box p {
                color: #495057;
                transition: color 0.5s ease-in-out;
            }

            .info-box:hover p {
                color: #343a40;
            }
        </style>
    </head>

    <body>

        <div class="py-3">
            <div class="header">
                <b>
                    <h1>Informasi Tugas Akhir dan Jurusan Teknologi Informasi</h1>
                </b>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="info-box">
                        <h2>Tugas Akhir</h2>
                        <p>Temukan informasi terkini tentang Tugas Akhir di Jurusan Teknologi Informasi.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <h2>Jurusan Teknologi Informasi</h2>
                        <p>Temukan informasi tentang program studi, kurikulum, dan fasilitas di Jurusan Teknologi Informasi.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <h2>Dosen Pembimbing</h2>
                        <p>Dapatkan informasi tentang dosen pembimbing dan jadwal konsultasi untuk Tugas Akhir.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <h2>Program Studi</h2>
                        <p>Silahkan pilih informasi program study</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <h2>Alumni</h2>
                        <p>Temukan kesempatan karir dan informasi tentang alumni Jurusan Teknologi Informasi.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <h2>Persyaratan TA</h2>
                        <p>Cek persyaratan yang harus dipenuhi untuk mengajukan Tugas Akhir.</p>
                    </div>
                </div>
            </div>
        </div>

    </body>

    </html>
@endsection

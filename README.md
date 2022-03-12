# D-Health
## Project overview
Projek ini dibuat untuk kebutuhan pembelajaran sekaligus testing. Menggunakan docker untuk mengisolasi aplikasi yang terdiri dari framework Laravel (PHP) dan NuxtJS (VueJS). Database sudah include dalam docker-compose menggunakan MySQL.

## Tools & Attention
1. Docker & docker-compose sudah terinstall
2. Pastikan port 9002 dan 3407 tidak terpakai. Port 9002 secara default akan menjadi port untuk menjalankan project ini (http://localhost:9002). Port 3407 akan di-binding untuk database MySQL yang dijalankan dari container.

## Installation
1. Copy file ```.env.prod``` pada direktori app-laravel, dan paste menjadi ```.env``` di direktori yang sama.
2. Copy file ```.env-example``` pada direktori nuxt-adminlte, dan paste menjadi ```.env``` di direktori yang sama.
3. Mulai build projek ini menggunakan docker. Silahkan menyesuaikan sesuai OS Anda (CLI atau UI). Berikut contoh command build di Linux - Ubuntu.
```bash
$ docker-compose up -d --build
```

## Running the app
1. Pada lokal komputer, aplikasi dapat diakses di http://localhost:9002
2. Gunakan credential login dengan email: admin@mail.com dan password: 12345
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pesan Validasi Bahasa Indonesia
    |--------------------------------------------------------------------------
    */

    'accepted'             => 'Kolom :attribute harus diterima.',
    'accepted_if'          => 'Kolom :attribute harus diterima jika :other bernilai :value.',
    'active_url'           => 'Kolom :attribute bukan URL yang valid.',
    'after'                => 'Kolom :attribute harus berisi tanggal setelah :date.',
    'after_or_equal'       => 'Kolom :attribute harus berisi tanggal setelah atau sama dengan :date.',
    'alpha'                => 'Kolom :attribute hanya boleh berisi huruf.',
    'alpha_dash'           => 'Kolom :attribute hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num'            => 'Kolom :attribute hanya boleh berisi huruf dan angka.',
    'array'                => 'Kolom :attribute harus berupa array.',
    'ascii'                => 'Kolom :attribute hanya boleh berisi karakter alfanumerik dan simbol satu byte.',
    'before'               => 'Kolom :attribute harus berisi tanggal sebelum :date.',
    'before_or_equal'      => 'Kolom :attribute harus berisi tanggal sebelum atau sama dengan :date.',
    'between'              => [
        'array'   => 'Kolom :attribute harus memiliki antara :min dan :max item.',
        'file'    => 'Kolom :attribute harus berukuran antara :min dan :max kilobyte.',
        'numeric' => 'Kolom :attribute harus bernilai antara :min dan :max.',
        'string'  => 'Kolom :attribute harus memiliki antara :min dan :max karakter.',
    ],
    'boolean'              => 'Kolom :attribute harus bernilai benar atau salah.',
    'can'                  => 'Kolom :attribute mengandung nilai yang tidak diizinkan.',
    'confirmed'            => 'Konfirmasi kolom :attribute tidak cocok.',
    'current_password'     => 'Kata sandi saat ini salah.',
    'date'                 => 'Kolom :attribute bukan tanggal yang valid.',
    'date_equals'          => 'Kolom :attribute harus berisi tanggal yang sama dengan :date.',
    'date_format'          => 'Kolom :attribute tidak sesuai dengan format :format.',
    'decimal'              => 'Kolom :attribute harus memiliki :decimal angka desimal.',
    'declined'             => 'Kolom :attribute harus ditolak.',
    'declined_if'          => 'Kolom :attribute harus ditolak jika :other bernilai :value.',
    'different'            => 'Kolom :attribute dan :other harus berbeda.',
    'digits'               => 'Kolom :attribute harus terdiri dari :digits digit.',
    'digits_between'       => 'Kolom :attribute harus terdiri dari :min sampai :max digit.',
    'dimensions'           => 'Kolom :attribute memiliki dimensi gambar yang tidak valid.',
    'distinct'             => 'Kolom :attribute memiliki nilai yang duplikat.',
    'doesnt_end_with'      => 'Kolom :attribute tidak boleh diakhiri dengan salah satu dari berikut: :values.',
    'doesnt_start_with'    => 'Kolom :attribute tidak boleh diawali dengan salah satu dari berikut: :values.',
    'email'                => 'Kolom :attribute harus berupa alamat email yang valid.',
    'ends_with'            => 'Kolom :attribute harus diakhiri dengan salah satu dari berikut: :values.',
    'enum'                 => 'Nilai yang dipilih pada kolom :attribute tidak valid.',
    'exists'               => 'Nilai yang dipilih pada kolom :attribute tidak valid.',
    'extensions'           => 'Kolom :attribute harus memiliki ekstensi: :values.',
    'file'                 => 'Kolom :attribute harus berupa file.',
    'filled'               => 'Kolom :attribute harus diisi.',
    'gt'                   => [
        'array'   => 'Kolom :attribute harus memiliki lebih dari :value item.',
        'file'    => 'Kolom :attribute harus berukuran lebih dari :value kilobyte.',
        'numeric' => 'Kolom :attribute harus bernilai lebih dari :value.',
        'string'  => 'Kolom :attribute harus memiliki lebih dari :value karakter.',
    ],
    'gte'                  => [
        'array'   => 'Kolom :attribute harus memiliki :value item atau lebih.',
        'file'    => 'Kolom :attribute harus berukuran lebih dari atau sama dengan :value kilobyte.',
        'numeric' => 'Kolom :attribute harus bernilai lebih dari atau sama dengan :value.',
        'string'  => 'Kolom :attribute harus memiliki lebih dari atau sama dengan :value karakter.',
    ],
    'hex_color'            => 'Kolom :attribute harus berupa warna heksadesimal yang valid.',
    'image'                => 'Kolom :attribute harus berupa gambar.',
    'in'                   => 'Nilai yang dipilih pada kolom :attribute tidak valid.',
    'in_array'             => 'Kolom :attribute tidak ada di :other.',
    'integer'              => 'Kolom :attribute harus berupa bilangan bulat.',
    'ip'                   => 'Kolom :attribute harus berupa alamat IP yang valid.',
    'ipv4'                 => 'Kolom :attribute harus berupa alamat IPv4 yang valid.',
    'ipv6'                 => 'Kolom :attribute harus berupa alamat IPv6 yang valid.',
    'json'                 => 'Kolom :attribute harus berupa string JSON yang valid.',
    'lowercase'            => 'Kolom :attribute harus berupa huruf kecil.',
    'lt'                   => [
        'array'   => 'Kolom :attribute harus memiliki kurang dari :value item.',
        'file'    => 'Kolom :attribute harus berukuran kurang dari :value kilobyte.',
        'numeric' => 'Kolom :attribute harus bernilai kurang dari :value.',
        'string'  => 'Kolom :attribute harus memiliki kurang dari :value karakter.',
    ],
    'lte'                  => [
        'array'   => 'Kolom :attribute harus memiliki maksimal :value item.',
        'file'    => 'Kolom :attribute harus berukuran kurang dari atau sama dengan :value kilobyte.',
        'numeric' => 'Kolom :attribute harus bernilai kurang dari atau sama dengan :value.',
        'string'  => 'Kolom :attribute harus memiliki kurang dari atau sama dengan :value karakter.',
    ],
    'mac_address'          => 'Kolom :attribute harus berupa alamat MAC yang valid.',
    'max'                  => [
        'array'   => 'Kolom :attribute tidak boleh memiliki lebih dari :max item.',
        'file'    => 'Kolom :attribute tidak boleh berukuran lebih dari :max kilobyte.',
        'numeric' => 'Kolom :attribute tidak boleh bernilai lebih dari :max.',
        'string'  => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
    ],
    'max_digits'           => 'Kolom :attribute tidak boleh memiliki lebih dari :max digit.',
    'mimes'                => 'Kolom :attribute harus berupa file bertipe: :values.',
    'mimetypes'            => 'Kolom :attribute harus berupa file bertipe: :values.',
    'min'                  => [
        'array'   => 'Kolom :attribute harus memiliki setidaknya :min item.',
        'file'    => 'Kolom :attribute harus berukuran setidaknya :min kilobyte.',
        'numeric' => 'Kolom :attribute harus bernilai setidaknya :min.',
        'string'  => 'Kolom :attribute harus memiliki setidaknya :min karakter.',
    ],
    'min_digits'           => 'Kolom :attribute harus memiliki setidaknya :min digit.',
    'missing'              => 'Kolom :attribute harus tidak ada.',
    'missing_if'           => 'Kolom :attribute harus tidak ada jika :other bernilai :value.',
    'missing_unless'       => 'Kolom :attribute harus tidak ada kecuali :other bernilai :value.',
    'missing_with'         => 'Kolom :attribute harus tidak ada jika :values ada.',
    'missing_with_all'     => 'Kolom :attribute harus tidak ada jika :values semua ada.',
    'multiple_of'          => 'Kolom :attribute harus merupakan kelipatan dari :value.',
    'not_in'               => 'Nilai yang dipilih pada kolom :attribute tidak valid.',
    'not_regex'            => 'Format kolom :attribute tidak valid.',
    'numeric'              => 'Kolom :attribute harus berupa angka.',
    'password'             => [
        'letters'       => 'Kolom :attribute harus mengandung setidaknya satu huruf.',
        'mixed'         => 'Kolom :attribute harus mengandung setidaknya satu huruf besar dan satu huruf kecil.',
        'numbers'       => 'Kolom :attribute harus mengandung setidaknya satu angka.',
        'symbols'       => 'Kolom :attribute harus mengandung setidaknya satu simbol.',
        'uncompromised' => 'Kolom :attribute yang diberikan pernah terungkap dalam kebocoran data. Silakan gunakan nilai yang berbeda.',
    ],
    'present'              => 'Kolom :attribute harus ada.',
    'present_if'           => 'Kolom :attribute harus ada jika :other bernilai :value.',
    'present_unless'       => 'Kolom :attribute harus ada kecuali :other bernilai :value.',
    'present_with'         => 'Kolom :attribute harus ada jika :values ada.',
    'present_with_all'     => 'Kolom :attribute harus ada jika semua :values ada.',
    'prohibited'           => 'Kolom :attribute tidak diizinkan.',
    'prohibited_if'        => 'Kolom :attribute tidak diizinkan jika :other bernilai :value.',
    'prohibited_unless'    => 'Kolom :attribute tidak diizinkan kecuali :other berada di :values.',
    'prohibits'            => 'Kolom :attribute melarang keberadaan :other.',
    'regex'                => 'Format kolom :attribute tidak valid.',
    'required'             => 'Kolom :attribute wajib diisi.',
    'required_array_keys'  => 'Kolom :attribute harus mengandung entri untuk: :values.',
    'required_if'          => 'Kolom :attribute wajib diisi jika :other bernilai :value.',
    'required_if_accepted' => 'Kolom :attribute wajib diisi jika :other diterima.',
    'required_unless'      => 'Kolom :attribute wajib diisi kecuali :other berada di :values.',
    'required_with'        => 'Kolom :attribute wajib diisi jika :values ada.',
    'required_with_all'    => 'Kolom :attribute wajib diisi jika semua :values ada.',
    'required_without'     => 'Kolom :attribute wajib diisi jika :values tidak ada.',
    'required_without_all' => 'Kolom :attribute wajib diisi jika semua :values tidak ada.',
    'same'                 => 'Kolom :attribute dan :other harus sama.',
    'size'                 => [
        'array'   => 'Kolom :attribute harus memiliki :size item.',
        'file'    => 'Kolom :attribute harus berukuran :size kilobyte.',
        'numeric' => 'Kolom :attribute harus bernilai :size.',
        'string'  => 'Kolom :attribute harus memiliki :size karakter.',
    ],
    'starts_with'          => 'Kolom :attribute harus dimulai dengan salah satu dari berikut: :values.',
    'string'               => 'Kolom :attribute harus berupa string.',
    'timezone'             => 'Kolom :attribute harus berupa zona waktu yang valid.',
    'unique'               => 'Kolom :attribute sudah digunakan.',
    'uploaded'             => 'Kolom :attribute gagal diunggah.',
    'uppercase'            => 'Kolom :attribute harus berupa huruf besar.',
    'url'                  => 'Kolom :attribute harus berupa URL yang valid.',
    'ulid'                 => 'Kolom :attribute harus berupa ULID yang valid.',
    'uuid'                 => 'Kolom :attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Attribute Names
    |--------------------------------------------------------------------------
    */
    'attributes' => [
        // Auth
        'email'                => 'email',
        'password'             => 'kata sandi',
        'username'             => 'nama pengguna',

        // Perpustakaan
        'kode_buku'            => 'kode buku',
        'judul_buku'           => 'judul buku',
        'pengarang'            => 'pengarang',
        'penulis'              => 'penulis',
        'penerbit'             => 'penerbit',
        'tahun_terbit'         => 'tahun terbit',
        'isbn'                 => 'ISBN',
        'kategori_buku'        => 'kategori buku',
        'sinopsis'             => 'sinopsis',
        'foto_buku'            => 'foto sampul',
        'jumlah_buku'          => 'jumlah buku',
        'kondisi_buku'         => 'kondisi buku',
        'nama_peminjam'        => 'nama peminjam',
        'tanggal_pinjam'       => 'tanggal pinjam',
        'tanggal_kembali'      => 'batas kembali',

        // Inventaris
        'kode_barang'          => 'kode barang',
        'nama_barang'          => 'nama barang',
        'jumlah'               => 'jumlah',
        'satuan'               => 'satuan',
        'lokasi'               => 'lokasi',
        'kondisi'              => 'kondisi',

        // Stok
        'nama_stok'            => 'nama stok',
        'stok'                 => 'stok',
        'stok_minimal'         => 'batas minimal stok',
        'satuan_stok'          => 'satuan',

        // Anak asuh
        'nama_lengkap'         => 'nama lengkap',
        'tanggal_lahir'        => 'tanggal lahir',
        'jenis_kelamin'        => 'jenis kelamin',
        'alamat'               => 'alamat',
        'asal_sekolah'         => 'asal sekolah',
        'status'               => 'status',

        // Donasi
        'nominal'              => 'nominal',
        'nama_donatur'         => 'nama donatur',
        'tanggal_donasi'       => 'tanggal donasi',
        'metode_pembayaran'    => 'metode pembayaran',
        'bukti_transfer'       => 'bukti transfer',
        'catatan'              => 'catatan',
        'pesan'                => 'pesan',

        // Pengeluaran
        'keterangan'           => 'keterangan',
        'tanggal_pengeluaran'  => 'tanggal pengeluaran',
        'kategori'             => 'kategori',

        // Account request
        'nama'                 => 'nama',
        'no_telepon'           => 'nomor telepon',
        'alasan'               => 'alasan',

        // Users
        'name'                 => 'nama',
        'role'                 => 'peran',
        'new_password'         => 'kata sandi baru',
        'new_password_confirmation' => 'konfirmasi kata sandi baru',
    ],

    /*
    |--------------------------------------------------------------------------
    | Pesan Kustom per Field
    |--------------------------------------------------------------------------
    */
    'custom' => [
        'tanggal_kembali' => [
            'after'    => 'Batas kembali harus lebih lambat dari tanggal pinjam — keduanya tidak boleh sama.',
            'required' => 'Batas kembali wajib diisi.',
            'date'     => 'Batas kembali harus berupa tanggal yang valid.',
        ],
        'tanggal_pinjam' => [
            'required' => 'Tanggal pinjam wajib diisi.',
            'date'     => 'Tanggal pinjam harus berupa tanggal yang valid.',
        ],
    ],
];


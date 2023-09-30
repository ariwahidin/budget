
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    // Lakukan apa pun yang perlu Anda lakukan dengan data ini (misalnya, simpan ke database atau prosesnya)
    
    // Contoh respons JSON kembali ke JavaScript
    $response = array('status' => 'success', 'message' => 'Data formulir berhasil diterima.');
    echo json_encode($response);
    exit;
} else {
    // Jika bukan permintaan POST, tangani sesuai kebutuhan Anda
    http_response_code(405); // Method Not Allowed
    echo 'Metode tidak diizinkan';
}
?>


<form id="myForm">
    <input type="text" name="nama" value="John Doe">
    <input type="email" name="email" value="johndoe@example.com">
    <button type="submit">Kirim</button>
</form>

<script>

document.getElementById('myForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Mencegah pengiriman formulir tradisional

    const formData = new FormData(this); // Membuat objek FormData dari formulir

    fetch('cekx.php', {
        method: 'POST',
        body: formData // Menggunakan objek FormData sebagai body
    })
    .then(response => response.json())
    .then(data => {
        // Menangani respons dari server (misalnya, tampilkan pesan atau lakukan sesuatu dengan data)
        console.log(data);
    })
    .catch(error => {
        // Menangani kesalahan yang terjadi selama request
        console.error('Error:', error);
    });
});
</script>
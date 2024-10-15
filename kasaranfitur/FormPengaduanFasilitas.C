#include <stdio.h>
#include <string.h> // Untuk fungsi strcspn()

int main() {
    // Deklarasi variabel untuk menyimpan data pengaduan
    char namaPengadu[100];
    char nomorTelpon[20];
    char tanggalMenginap[11]; // Format YYYY-MM-DD
    char tanggalMelaporkan[11]; // Format YYYY-MM-DD
    char tempatKerusakan[100];
    char jenisMasalah[50];
    char kategoriFasilitas[50];
    char deskripsiMasalah[500];
    char buktiGambar[100]; // Nama file gambar bukti

    // Mencetak judul
    printf("Laporan Pengaduan Fasilitas\n");
    printf("============================\n");

    // Input data pengaduan
    printf("Nama Pengadu: ");
    fgets(namaPengadu, sizeof(namaPengadu), stdin);
    namaPengadu[strcspn(namaPengadu, "\n")] = '\0'; // Menghapus newline

    printf("Nomor Telepon Pengadu: ");
    fgets(nomorTelpon, sizeof(nomorTelpon), stdin);
    nomorTelpon[strcspn(nomorTelpon, "\n")] = '\0'; // Menghapus newline

    printf("Tanggal Menginap (YYYY-MM-DD): ");
    fgets(tanggalMenginap, sizeof(tanggalMenginap), stdin);
    tanggalMenginap[strcspn(tanggalMenginap, "\n")] = '\0'; // Menghapus newline

    printf("Tanggal Melaporkan (YYYY-MM-DD): ");
    fgets(tanggalMelaporkan, sizeof(tanggalMelaporkan), stdin);  
    tanggalMelaporkan[strcspn(tanggalMelaporkan, "\n")] = '\0'; // Menghapus newline

    printf("Tempat Kerusakan: ");
    fgets(tempatKerusakan, sizeof(tempatKerusakan), stdin);
    tempatKerusakan[strcspn(tempatKerusakan, "\n")] = '\0'; // Menghapus newline

    printf("Jenis Masalah (Wifi, AC, Water Heater, Wastafel, Bed, Lainnya): ");
    fgets(jenisMasalah, sizeof(jenisMasalah), stdin);
    jenisMasalah[strcspn(jenisMasalah, "\n")] = '\0'; // Menghapus newline

    printf("Kategori Fasilitas (Fasilitas umum, Fasilitas pribadi): ");
    fgets(kategoriFasilitas, sizeof(kategoriFasilitas), stdin);
    kategoriFasilitas[strcspn(kategoriFasilitas, "\n")] = '\0'; // Menghapus newline

    printf("Deskripsi Masalah: ");
    fgets(deskripsiMasalah, sizeof(deskripsiMasalah), stdin);
    deskripsiMasalah[strcspn(deskripsiMasalah, "\n")] = '\0'; // Menghapus newline

    printf("Unggah Bukti (nama file gambar): ");
    fgets(buktiGambar, sizeof(buktiGambar), stdin);
    buktiGambar[strcspn(buktiGambar, "\n")] = '\0'; // Menghapus newline

    // Menampilkan ringkasan pengaduan dengan nama pengadu
    printf("\n--- Data Pengaduan %s ---\n", namaPengadu);
    printf("Nama Pengadu: %s\n", namaPengadu);
    printf("Nomor Telepon: %s\n", nomorTelpon);
    printf("Tanggal Menginap: %s\n", tanggalMenginap);
    printf("Tanggal Melaporkan: %s\n", tanggalMelaporkan);
    printf("Tempat Kerusakan: %s\n", tempatKerusakan);
    printf("Jenis Masalah: %s\n", jenisMasalah);
    printf("Kategori Fasilitas: %s\n", kategoriFasilitas);
    printf("Deskripsi Masalah: %s\n", deskripsiMasalah);
    printf("Bukti Gambar: %s\n", buktiGambar);

    return 0;
}
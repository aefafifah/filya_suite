#include <stdio.h>
#include <stdlib.h>
#include <string.h>

// Struktur untuk laporan pengaduan
typedef struct {
    char name[100];
    char reportDate[11]; // Format: YYYY-MM-DD
    char phone[15];      // Ukuran buffer untuk nomor telepon
    char problemType[50];
    char description[500];
    char imagePath[200]; // Path untuk bukti file
} ComplaintReport;

// Fungsi untuk mengisi laporan pengaduan
void fillComplaintReport(ComplaintReport *report) {
    printf("=== Form Laporan Pengaduan ===\n\n");

    printf("Nama: ");
    fgets(report->name, sizeof(report->name), stdin);
    report->name[strcspn(report->name, "\n")] = 0; // Hapus newline

    printf("Tanggal Melaporkan (YYYY-MM-DD): ");
    fgets(report->reportDate, sizeof(report->reportDate), stdin);
    report->reportDate[strcspn(report->reportDate, "\n")] = 0; // Hapus newline

    printf("Nomor Telepon: ");
    scanf("%14s", report->phone);
    while (getchar() != '\n');  // Hapus newline yang tersisa

    printf("Jenis Masalah (Kerusakan Bangunan, Kebersihan Villa, Perawatan yang Kurang, Lainnya): ");
    fgets(report->problemType, sizeof(report->problemType), stdin);
    report->problemType[strcspn(report->problemType, "\n")] = 0; // Hapus newline

    printf("Deskripsi Masalah: ");
    fgets(report->description, sizeof(report->description), stdin);
    report->description[strcspn(report->description, "\n")] = 0; // Hapus newline

    printf("Bukti Gambar (Path): ");
    fgets(report->imagePath, sizeof(report->imagePath), stdin);
    report->imagePath[strcspn(report->imagePath, "\n")] = 0; // Hapus newline
}

// Fungsi untuk menampilkan laporan pengaduan
void displayReport(const ComplaintReport *report) {
    printf("\n=== Laporan Pengaduan ===\n");
    printf("--------------------------\n");
    printf("Nama                : %s\n", report->name);
    printf("Tanggal Melaporkan  : %s\n", report->reportDate);
    printf("Nomor Telepon       : %s\n", report->phone);
    printf("Jenis Masalah       : %s\n", report->problemType);
    printf("Deskripsi Masalah   : %s\n", report->description);
    printf("Bukti Gambar        : %s\n", report->imagePath);
    printf("--------------------------\n");
}

int main() {
    ComplaintReport report;
    fillComplaintReport(&report);
    displayReport(&report);

    // Menambahkan pesan bahwa laporan berhasil dikirim
    printf("Laporan Anda telah berhasil dikirim dan akan segera kami proses! \n");

    return 0;
}


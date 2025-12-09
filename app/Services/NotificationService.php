<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Bookings;

class NotificationService
{
    /**
     * Create a generic notification
     *
     * @param int $userId
     * @param string $message
     * @param string $type
     * @param int|null $relatedId
     * @param string|null $category
     * @return Notification
     */
    public function createNotification($userId, $message, $type, $relatedId = null, $category = null)
    {
        try {
            // Optimasi: langsung buat array tanpa check fillable berulang-ulang
            $notification = Notification::create([
                'user_id' => $userId,
                'pesan' => $message,
                'type' => $type,
                'related_id' => $relatedId,
                'category' => $category,
                'notification_time' => now(),
                'is_read' => false,
            ]);
            
            // Hanya log jika error, untuk performa lebih baik
            // \Log::info('Notification created in database', [...]);
            
            return $notification;
        } catch (\Exception $e) {
            \Log::error('Failed to create notification in database', [
                'user_id' => $userId,
                'message' => $message,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Create notification for booking created
     *
     * @param Bookings $booking
     * @param int|null $sks Jumlah SKS (jika tidak diberikan, akan dihitung dari durasi)
     * @return Notification
     */
    public function notifyBookingCreated(Bookings $booking, $sks = null)
    {
        // Load jadwalKelas jika belum di-load
        if (!$booking->relationLoaded('jadwalKelas')) {
            $booking->load('jadwalKelas');
        }

        // Format waktu dari booking_time
        $bookingTime = $booking->booking_time ?? now();
        
        // Set locale ke Indonesia untuk format tanggal
        \Carbon\Carbon::setLocale('id');
        $jam = $bookingTime->format('H:i');
        $tanggal = $bookingTime->translatedFormat('d F Y'); // Format Indonesia
        
        // Hitung SKS jika tidak diberikan
        if ($sks === null && $booking->jadwalKelas) {
            $startTime = $booking->jadwalKelas->start_time;
            $endTime = $booking->jadwalKelas->end_time;
            if ($startTime && $endTime) {
                $durasiMenit = $startTime->diffInMinutes($endTime);
                $sks = round($durasiMenit / 50); // 1 SKS = 50 menit
            } else {
                $sks = 1; // Default jika tidak bisa dihitung
            }
        } elseif ($sks === null) {
            $sks = 1; // Default jika tidak ada jadwalKelas
        }
        
        // Format pesan sesuai permintaan: "Booking berhasil dibuat pada {tanggal} di {jam} selama {sks}sks"
        $message = "Booking berhasil dibuat pada {$tanggal} di {$jam} selama {$sks} sks";

        try {
            $notification = $this->createNotification(
                $booking->user_id,
                $message,
                'booking',
                $booking->booking_id,
                'booking'
            );
            
            // Hapus logging untuk performa lebih baik
            // \Log::info('Notification created successfully', [...]);
            
            return $notification;
        } catch (\Exception $e) {
            \Log::error('Error creating notification', [
                'booking_id' => $booking->booking_id,
                'user_id' => $booking->user_id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            throw $e;
        }
    }

    /**
     * Create notification for booking approved
     *
     * @param Bookings $booking
     * @return Notification
     */
    public function notifyBookingApproved(Bookings $booking)
    {
        // Load relationships
        $booking->load(['jadwalKelas.laboratorium']);

        $labName = $booking->jadwalKelas->laboratorium->room_name ?? 'Lab';
        $time = $booking->jadwalKelas->start_time->format('H:i');

        $message = "Booking {$labName} {$time} disetujui!";

        return $this->createNotification(
            $booking->user_id,
            $message,
            'booking_approved',
            $booking->booking_id,
            'booking'
        );
    }

    /**
     * Create notification for booking rejected
     *
     * @param Bookings $booking
     * @param string $reason
     * @return Notification
     */
    public function notifyBookingRejected(Bookings $booking, $reason)
    {
        // Load relationships
        $booking->load(['jadwalKelas.laboratorium']);

        $labName = $booking->jadwalKelas->laboratorium->room_name ?? 'Lab';
        $time = $booking->jadwalKelas->start_time->format('H:i');

        $message = "Booking {$labName} {$time} dibatalkan oleh admin - Alasan: {$reason}";

        return $this->createNotification(
            $booking->user_id,
            $message,
            'booking_rejected',
            $booking->booking_id,
            'booking'
        );
    }
}

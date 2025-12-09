# Automated Tests - Riwayat Booking

Test suite untuk endpoint `/api/bookings/history` menggunakan Playwright.

## Setup

1. **Install dependencies** (jika belum):
   ```bash
   npm install
   ```

2. **Install Playwright browsers** (jika belum):
   ```bash
   npx playwright install
   ```

3. **Konfigurasi Test User**:
   - Buka file `riwayat-api.spec.js` dan `riwayat-frontend.spec.js`
   - Update `TEST_USER` object dengan credentials yang valid:
     ```javascript
     const TEST_USER = {
       login: 'mahasiswa',
       password: 'mahasiswa'
     };
     ```

4. **Set Base URL** (opsional):
   - Default: `http://localhost:8000`
   - Untuk mengubah, set environment variable:
     ```bash
     export BASE_URL=http://your-url:port
     # atau di Windows PowerShell:
     $env:BASE_URL="http://your-url:port"
     ```

## Menjalankan Tests

### Run semua tests:
```bash
npm test
# atau
npx playwright test
```

### Run dengan UI mode (interaktif):
```bash
npm run test:ui
# atau
npx playwright test --ui
```

### Run dengan browser visible (headed mode):
```bash
npm run test:headed
# atau
npx playwright test --headed
```

### Run dalam debug mode:
```bash
npm run test:debug
# atau
npx playwright test --debug
```

### Run test tertentu:
```bash
npx playwright test riwayat-api.spec.js
npx playwright test riwayat-frontend.spec.js
```

### Run test dengan filter:
```bash
# Run hanya test yang mengandung "TS-RIWAYAT-028"
npx playwright test -g "TS-RIWAYAT-028"
```

## Test Files

### `riwayat-api.spec.js`
Test untuk API endpoint `/api/bookings/history`:
- TS-RIWAYAT-028: GET list booking user yang login
- TS-RIWAYAT-029: User hanya bisa melihat booking sendiri
- TS-RIWAYAT-032: Filter status (aktif, completed, nonaktif)
- TS-RIWAYAT-035: Response format sesuai specification
- TS-RIWAYAT-036: Return 401 jika tidak terautentikasi
- TS-RIWAYAT-038: Route accessible via session auth
- TS-RIWAYAT-040: Route accessible dari frontend

### `riwayat-frontend.spec.js`
Test untuk UI/frontend:
- Navigasi ke halaman riwayat
- Display booking table
- Filter by status (client-side)
- Search bookings (client-side)
- Filter by tanggal (client-side)
- Loading state
- Empty state
- Display booking details

## Test Results

Setelah menjalankan test, hasil akan tersimpan di:
- **HTML Report**: `test-results/` folder
- **JSON Report**: `test-results/results.json`

Untuk melihat HTML report:
```bash
npm run test:report
# atau
npx playwright show-report
```

## Troubleshooting

### Test gagal karena tidak bisa login:
1. Pastikan credentials di `TEST_USER` benar
2. Pastikan aplikasi Laravel sudah running
3. Pastikan base URL benar (default: `http://localhost:8000`)

### Test gagal karena element tidak ditemukan:
1. Pastikan halaman sudah fully loaded
2. Check selector di test file, mungkin perlu disesuaikan dengan HTML yang sebenarnya
3. Gunakan `--headed` mode untuk melihat apa yang terjadi

### Session cookie tidak terkirim:
1. Pastikan login berhasil (check dengan `--headed` mode)
2. Pastikan base URL sama untuk login dan API request

## Menambahkan Test Baru

Untuk menambahkan test baru, buat file baru di folder `tests/riwayat-test/` dengan format:

```javascript
import { test, expect } from '@playwright/test';

test.describe('Test Name', () => {
  test('should do something', async ({ page }) => {
    // Test implementation
  });
});
```

## Catatan

- Test menggunakan session-based authentication (bukan JWT)
- Beberapa test memerlukan data booking di database
- Filter tanggal, kelas, dan ruang dilakukan di client-side, jadi test untuk itu ada di `riwayat-frontend.spec.js`
- Test untuk N+1 query problem tidak bisa di-automate dengan Playwright, perlu menggunakan Laravel Debugbar atau query log



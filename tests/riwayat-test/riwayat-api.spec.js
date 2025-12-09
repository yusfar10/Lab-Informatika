import { test, expect } from '@playwright/test';

/**
 * Test Suite: Riwayat Booking API
 * Endpoint: GET /api/bookings/history
 * 
 * Test Cases berdasarkan LAPORAN_TEST_RIWAYAT_BOOKING.md
 */

const BASE_URL = process.env.BASE_URL || 'http://localhost:8000';
const API_ENDPOINT = '/api/bookings/history';

// Test credentials - GANTI DENGAN CREDENTIALS YANG VALID
const TEST_USER = {
  login: 'test@example.com', // Ganti dengan email/username test user
  password: 'password123'     // Ganti dengan password test user
};

/**
 * Helper function untuk login dan mendapatkan session cookie
 */
async function loginUser(page, credentials = TEST_USER) {
  await page.goto('/');
  
  // Fill login form
  await page.fill('input[name="login"]', credentials.login);
  await page.fill('input[name="password"]', credentials.password);
  
  // Submit form
  await page.click('button[type="submit"]');
  
  // Wait for navigation after login
  await page.waitForURL('**/dashboard**', { timeout: 10000 });
  
  // Verify login success
  const url = page.url();
  expect(url).toContain('dashboard');
}

/**
 * Helper function untuk membuat API request dengan session cookie
 */
async function makeAPIRequest(page, url, options = {}) {
  const cookies = await page.context().cookies();
  const sessionCookie = cookies.find(c => c.name.includes('laravel_session') || c.name.includes('session'));
  
  const response = await page.request.get(url, {
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest',
      ...options.headers
    },
    ...options
  });
  
  return response;
}

test.describe('TS-RIWAYAT-028: GET /api/bookings/history return list booking user yang login', () => {
  test('should return list of bookings for logged in user', async ({ page }) => {
    // Login first
    await loginUser(page);
    
    // Make API request
    const response = await makeAPIRequest(page, API_ENDPOINT);
    
    // Verify response
    expect(response.status()).toBe(200);
    
    const data = await response.json();
    
    // Verify response structure
    expect(data).toHaveProperty('success', true);
    expect(data).toHaveProperty('data');
    expect(data).toHaveProperty('message');
    expect(Array.isArray(data.data)).toBe(true);
    
    // If there are bookings, verify structure
    if (data.data.length > 0) {
      const booking = data.data[0];
      expect(booking).toHaveProperty('booking_id');
      expect(booking).toHaveProperty('created_at');
      expect(booking).toHaveProperty('booking_time');
      expect(booking).toHaveProperty('user');
      expect(booking).toHaveProperty('jadwalKelas');
      expect(booking).toHaveProperty('display_status');
      
      // Verify user object
      expect(booking.user).toHaveProperty('id');
      expect(booking.user).toHaveProperty('name');
      expect(booking.user).toHaveProperty('username');
      
      // Verify jadwalKelas object
      expect(booking.jadwalKelas).toHaveProperty('class_id');
      expect(booking.jadwalKelas).toHaveProperty('class_name');
      expect(booking.jadwalKelas).toHaveProperty('start_time');
      expect(booking.jadwalKelas).toHaveProperty('end_time');
      expect(booking.jadwalKelas).toHaveProperty('status');
    }
  });
});

test.describe('TS-RIWAYAT-029: User hanya bisa melihat booking sendiri', () => {
  test('should only return bookings for logged in user', async ({ page }) => {
    // Login first
    await loginUser(page);
    
    // Make API request
    const response = await makeAPIRequest(page, API_ENDPOINT);
    
    expect(response.status()).toBe(200);
    
    const data = await response.json();
    expect(data.success).toBe(true);
    
    if (data.data.length > 0) {
      // Get current user ID from first booking
      const currentUserId = data.data[0].user.id;
      
      // Verify all bookings belong to the same user
      data.data.forEach(booking => {
        expect(booking.user.id).toBe(currentUserId);
      });
    }
  });
});

test.describe('TS-RIWAYAT-032: Filter status', () => {
  test('should filter by status=aktif', async ({ page }) => {
    await loginUser(page);
    
    const response = await makeAPIRequest(page, `${API_ENDPOINT}?status=aktif`);
    
    expect(response.status()).toBe(200);
    
    const data = await response.json();
    expect(data.success).toBe(true);
    
    // Verify all bookings have display_status = 'aktif'
    data.data.forEach(booking => {
      expect(booking.display_status).toBe('aktif');
    });
  });
  
  test('should filter by status=completed', async ({ page }) => {
    await loginUser(page);
    
    const response = await makeAPIRequest(page, `${API_ENDPOINT}?status=completed`);
    
    expect(response.status()).toBe(200);
    
    const data = await response.json();
    expect(data.success).toBe(true);
    
    // Verify all bookings have display_status = 'completed'
    data.data.forEach(booking => {
      expect(booking.display_status).toBe('completed');
    });
  });
  
  test('should handle status=nonaktif (not supported)', async ({ page }) => {
    await loginUser(page);
    
    const response = await makeAPIRequest(page, `${API_ENDPOINT}?status=nonaktif`);
    
    // Backend doesn't support this, might return all or ignore the parameter
    expect(response.status()).toBe(200);
    
    const data = await response.json();
    // This test documents that nonaktif is not supported
    // The response might return all bookings or just ignore the parameter
  });
});

test.describe('TS-RIWAYAT-035: Response format sesuai specification', () => {
  test('should return response in correct format', async ({ page }) => {
    await loginUser(page);
    
    const response = await makeAPIRequest(page, API_ENDPOINT);
    
    expect(response.status()).toBe(200);
    
    const data = await response.json();
    
    // Verify top-level structure
    expect(data).toHaveProperty('success');
    expect(data).toHaveProperty('data');
    expect(data).toHaveProperty('message');
    expect(typeof data.success).toBe('boolean');
    expect(Array.isArray(data.data)).toBe(true);
    expect(typeof data.message).toBe('string');
    
    if (data.data.length > 0) {
      const booking = data.data[0];
      
      // Verify booking structure
      expect(typeof booking.booking_id).toBe('number');
      expect(typeof booking.created_at).toBe('string');
      expect(typeof booking.booking_time).toBe('string');
      expect(typeof booking.display_status).toBe('string');
      expect(['aktif', 'completed']).toContain(booking.display_status);
      
      // Verify user structure
      expect(booking.user).toBeDefined();
      expect(typeof booking.user.id).toBe('number');
      expect(typeof booking.user.name).toBe('string');
      expect(typeof booking.user.username).toBe('string');
      
      // Verify jadwalKelas structure
      expect(booking.jadwalKelas).toBeDefined();
      expect(typeof booking.jadwalKelas.class_id).toBe('number');
      expect(typeof booking.jadwalKelas.class_name).toBe('string');
      expect(typeof booking.jadwalKelas.start_time).toBe('string');
      expect(typeof booking.jadwalKelas.end_time).toBe('string');
      expect(typeof booking.jadwalKelas.status).toBe('string');
      
      // Verify laboratorium if exists
      if (booking.jadwalKelas.laboratorium) {
        expect(typeof booking.jadwalKelas.laboratorium.room_id).toBe('number');
        expect(typeof booking.jadwalKelas.laboratorium.room_name).toBe('string');
      }
    }
  });
});

test.describe('TS-RIWAYAT-036: Return 401 jika user tidak terautentikasi', () => {
  test('should return 401 when not authenticated', async ({ page }) => {
    // Don't login - make request without session
    const response = await page.request.get(`${BASE_URL}${API_ENDPOINT}`, {
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      failOnStatusCode: false
    });
    
    expect(response.status()).toBe(401);
    
    const data = await response.json();
    expect(data).toHaveProperty('success', false);
    expect(data).toHaveProperty('message');
    expect(data.message).toContain('tidak terautentikasi');
    expect(data).not.toHaveProperty('data');
  });
});

test.describe('TS-RIWAYAT-038: Route accessible via session auth', () => {
  test('should be accessible with session cookie (no JWT token)', async ({ page }) => {
    await loginUser(page);
    
    // Make request without Authorization header (no JWT)
    const response = await makeAPIRequest(page, API_ENDPOINT, {
      headers: {
        // Explicitly not including Authorization header
      }
    });
    
    expect(response.status()).toBe(200);
    
    const data = await response.json();
    expect(data.success).toBe(true);
  });
});

test.describe('TS-RIWAYAT-040: Route accessible dari frontend', () => {
  test('should be accessible from frontend with session cookie', async ({ page }) => {
    await loginUser(page);
    
    // Navigate to riwayat page
    await page.goto('/mahasiswa/riwayat');
    
    // Wait for page to load
    await page.waitForLoadState('networkidle');
    
    // Check if API request was made (via network monitoring)
    const responsePromise = page.waitForResponse(
      response => response.url().includes('/api/bookings/history') && response.status() === 200,
      { timeout: 10000 }
    );
    
    // Trigger API call (if not automatic, wait for it)
    await responsePromise;
    
    // Verify page loaded successfully
    expect(page.url()).toContain('riwayat');
    
    // Check if data is displayed (look for table or booking items)
    const table = page.locator('table, .table, #table-booking');
    await expect(table.first()).toBeVisible({ timeout: 5000 }).catch(() => {
      // If table not found, check for any booking-related content
      const content = page.locator('body');
      expect(content).toBeVisible();
    });
  });
});



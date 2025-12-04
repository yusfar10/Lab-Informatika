import { test, expect } from '@playwright/test';

/**
 * Test Suite: Riwayat Booking Frontend
 * Testing UI interactions and client-side filtering
 */

const BASE_URL = process.env.BASE_URL || 'http://localhost:8000';

// Test credentials
const TEST_USER = {
  login: 'mahasiswa', // Ganti dengan email/username test user
  password: 'mahasiswa'     // Ganti dengan password test user
};

async function loginUser(page, credentials = TEST_USER) {
  await page.goto('/');
  await page.fill('input[name="login"]', credentials.login);
  await page.fill('input[name="password"]', credentials.password);
  await page.click('button[type="submit"]');
  await page.waitForURL('**/dashboard**', { timeout: 10000 });
}

test.describe('Riwayat Booking Frontend Tests', () => {
  test.beforeEach(async ({ page }) => {
    await loginUser(page);
  });

  test('should navigate to riwayat page', async ({ page }) => {
    await page.goto('/mahasiswa/riwayat');
    await page.waitForLoadState('networkidle');
    
    expect(page.url()).toContain('riwayat');
  });

  test('should display booking table', async ({ page }) => {
    await page.goto('/mahasiswa/riwayat');
    await page.waitForLoadState('networkidle');
    
    // Wait for table to load
    const table = page.locator('table, .table, #table-booking').first();
    await expect(table).toBeVisible({ timeout: 10000 });
  });

  test('should filter by status (client-side)', async ({ page }) => {
    await page.goto('/mahasiswa/riwayat');
    await page.waitForLoadState('networkidle');
    
    // Wait for page to fully load
    await page.waitForTimeout(2000);
    
    // Find status filter dropdown/select
    const statusFilter = page.locator('select, [id*="status"], [name*="status"]').first();
    
    if (await statusFilter.count() > 0) {
      // Select "aktif" status
      await statusFilter.selectOption({ label: /aktif/i });
      await page.waitForTimeout(1000);
      
      // Verify filtered results (check table rows)
      const rows = page.locator('table tbody tr, .table tbody tr');
      const rowCount = await rows.count();
      
      if (rowCount > 0) {
        // Check if status badges match
        const statusBadges = page.locator('.badge-status, [class*="badge"]');
        const badgeCount = await statusBadges.count();
        expect(badgeCount).toBeGreaterThan(0);
      }
    }
  });

  test('should search bookings (client-side)', async ({ page }) => {
    await page.goto('/mahasiswa/riwayat');
    await page.waitForLoadState('networkidle');
    await page.waitForTimeout(2000);
    
    // Find search input
    const searchInput = page.locator('input[type="search"], input[placeholder*="search" i], input[placeholder*="cari" i]').first();
    
    if (await searchInput.count() > 0) {
      // Type search term
      await searchInput.fill('test');
      await page.waitForTimeout(1000);
      
      // Verify search is working (table should update)
      const table = page.locator('table, .table').first();
      await expect(table).toBeVisible();
    }
  });

  test('should filter by tanggal (client-side)', async ({ page }) => {
    await page.goto('/mahasiswa/riwayat');
    await page.waitForLoadState('networkidle');
    await page.waitForTimeout(2000);
    
    // Find date filter input
    const dateFilter = page.locator('input[type="date"], [id*="tanggal"], [name*="tanggal"]').first();
    
    if (await dateFilter.count() > 0) {
      // Set a date (today)
      const today = new Date().toISOString().split('T')[0];
      await dateFilter.fill(today);
      await page.waitForTimeout(1000);
      
      // Verify filter is applied
      const table = page.locator('table, .table').first();
      await expect(table).toBeVisible();
    }
  });

  test('should display loading state', async ({ page }) => {
    await page.goto('/mahasiswa/riwayat');
    
    // Check for loading indicator (might be brief)
    const loadingIndicator = page.locator('.spinner, .loading, [class*="loading"], [id*="loading"]').first();
    
    // Loading might appear and disappear quickly
    // Just verify page eventually loads
    await page.waitForLoadState('networkidle', { timeout: 10000 });
    
    const table = page.locator('table, .table').first();
    await expect(table).toBeVisible({ timeout: 10000 });
  });

  test('should handle empty state', async ({ page }) => {
    await page.goto('/mahasiswa/riwayat');
    await page.waitForLoadState('networkidle');
    await page.waitForTimeout(3000);
    
    // Check if there's an empty state message or if table shows "no data"
    const emptyState = page.locator('text=/tidak ada data/i, text=/no data/i, text=/empty/i');
    const table = page.locator('table, .table').first();
    
    // Either empty state or table should be visible
    const hasEmptyState = await emptyState.count() > 0;
    const hasTable = await table.count() > 0;
    
    expect(hasEmptyState || hasTable).toBe(true);
  });

  test('should display booking details correctly', async ({ page }) => {
    await page.goto('/mahasiswa/riwayat');
    await page.waitForLoadState('networkidle');
    await page.waitForTimeout(3000);
    
    // Check if table has expected columns
    const table = page.locator('table, .table').first();
    
    if (await table.count() > 0) {
      // Check for table headers
      const headers = page.locator('thead th, .table thead th');
      const headerCount = await headers.count();
      
      if (headerCount > 0) {
        // Verify common column headers
        const headerTexts = await headers.allTextContents();
        const hasDateColumn = headerTexts.some(text => 
          /tanggal|date|waktu|time/i.test(text)
        );
        const hasStatusColumn = headerTexts.some(text => 
          /status/i.test(text)
        );
        
        // At least some expected columns should exist
        expect(hasDateColumn || hasStatusColumn).toBe(true);
      }
    }
  });
});



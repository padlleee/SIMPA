# Authentication & Security Module - Implementation Guide

## ✅ Features Implemented

### 1. **Login Pop-Up Modal (Landing Page)**

- Modern overlay modal on landing page
- Prevents accidental clicks outside (backyard click closes modal)
- Keyboard support (Esc to close)
- Auto-focuses username field
- Error display in modal
- Professional styling with smooth animations

**Files**:

- `resources/views/components/login-modal.blade.php`
- Updated: `resources/views/landing.blade.php`

**Usage**: Click "Masuk" button in navbar to open modal

---

### 2. **First-Login Password Change (Forced)**

Forces new user accounts to change default password before accessing dashboard

**Workflow**:

1. Admin creates user → `force_password_change = true`
2. User logs in with default credentials
3. Automatically redirects to password change page
4. User must create new password meeting requirements
5. Success page shown, then redirects to dashboard

**Files**:

- `resources/views/auth/password-change.blade.php`
- `resources/views/auth/password-change-success.blade.php`
- `app/Http/Controllers/AuthController.php` (new methods)
- `app/Http/Middleware/EnsurePasswordChanged.php` (new)

**Routes**:

- `GET /ubah-password` → `password.change`
- `POST /ubah-password` → `password.update`
- `GET /ubah-password-sukses` → `password.success`

---

### 3. **Password Change Requirements**

Enforced strong password policy:

- ✅ Minimum 8 characters
- ✅ At least one uppercase letter (A-Z)
- ✅ At least one lowercase letter (a-z)
- ✅ At least one digit (0-9)

Validation errors shown with clear messaging in Indonesian

**Files**:

- `app/Http/Controllers/AuthController.php::updatePassword()`

---

### 4. **Session Security & Login Tracking**

Automatic tracking of user login history and password changes

**New Fields in `users` table** (via migration):

- `force_password_change` (boolean) - Set true for new accounts
- `last_login_at` (timestamp) - Tracks latest login
- `password_changed_at` (timestamp) - Tracks password changes
- `status` (enum: active/inactive) - Account status

**Migration**:

- File: `database/migrations/2025_04_17_000001_add_password_change_tracking_to_users.php`
- Run: `php artisan migrate`

---

### 5. **Role-Based Redirects (Enhanced)**

After login, users automatically redirected to appropriate dashboard:

- **Admin/Ketua/Bendahara** → `/dashboard`
- **Donatur** → `/donatur/dashboard`
- **Others** → `/login` (invalid role)

**Implementation**: `AuthController::redirectByRole()`

---

### 6. **Session Management**

Enhanced security features:

- Session ID regeneration on login
- Session invalidation on logout
- CSRF token protection on all forms
- Proper HTTP-only cookie handling

**File**: `app/Http/Controllers/AuthController.php`

---

## 📊 Database Migration

To apply the new password tracking fields:

```bash
php artisan migrate
```

**New Columns in `users` table**:

```sql
ALTER TABLE users ADD COLUMN force_password_change BOOLEAN DEFAULT true;
ALTER TABLE users ADD COLUMN last_login_at TIMESTAMP NULL;
ALTER TABLE users ADD COLUMN password_changed_at TIMESTAMP NULL;
ALTER TABLE users ADD COLUMN status ENUM('active', 'inactive') DEFAULT 'active';
```

---

## 🔐 Authentication Flow

### New User (First Login)

```
┌─────────────────────────────────────────────┐
│  Admin creates account in user panel        │
│  force_password_change = true (default)     │
└──────────────────┬──────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────┐
│  User receives credentials (username/pwd)   │
│  Visits landing page, clicks "Masuk"        │
│  - Modal opens (login modal component)      │
│  - Enters username & default password       │
└──────────────────┬──────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────┐
│  AuthController::login() processes          │
│  - Credentials validated                    │
│  - last_login_at updated                    │
│  - Checks force_password_change flag        │
└──────────────────┬──────────────────────────┘
                   │
                   ▼ (if force_password_change = true)
┌─────────────────────────────────────────────┐
│  Redirect to password change page           │
│  /ubah-password (password.change route)     │
│  - User sees requirements                   │
│  - Enters current password (verification)   │
│  - Creates new secure password              │
└──────────────────┬──────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────┐
│  AuthController::updatePassword()           │
│  - Current password verified with Hash::check() │
│  - New password hashed & stored             │
│  - force_password_change = false            │
│  - password_changed_at = now()              │
└──────────────────┬──────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────┐
│  Redirect to success page                   │
│  Shows user info & success message          │
│  "Lanjut ke Dashboard" button                │
└──────────────────┬──────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────┐
│  Redirect to appropriate dashboard          │
│  redirectByRole() determines route          │
└─────────────────────────────────────────────┘
```

### Returning User (Normal Login)

```
┌─────────────────────────────────────────────┐
│  User on landing page clicks "Masuk"        │
│  Modal opens (login modal component)        │
│  Enters username & password                 │
└──────────────────┬──────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────┐
│  AuthController::login() processes          │
│  - Credentials validated                    │
│  - last_login_at updated                    │
│  - Checks force_password_change flag        │
└──────────────────┬──────────────────────────┘
                   │
                   ▼ (if force_password_change = false)
┌─────────────────────────────────────────────┐
│  Redirect to dashboard via redirectByRole() │
│  - Admin/Ketua → /dashboard                 │
│  - Donatur → /donatur/dashboard             │
└─────────────────────────────────────────────┘
```

---

## 🛠️ Controller Methods

### AuthController

#### `login(Request $request)`

- Validates username & password
- Updates `last_login_at` timestamp
- Checks for forced password change
- Returns errors or redirects appropriately

#### `showChangePassword()`

- Shows password change form
- Displays password requirements
- Validates user is authenticated

#### `updatePassword(Request $request)`

- Validates current password with Hash::check()
- Validates new password strength
- Updates password & tracking fields
- Clears force_password_change flag
- Redirects to success page

#### `passwordChangeSuccess()`

- Shows success message with user info
- Shows "Last Login" timestamp
- Provides link to dashboard

#### `redirectByRole($user)`

- Routes users to correct dashboard based on role
- Falls back to login if role invalid

---

## 🔍 Middleware

### EnsurePasswordChanged (New)

Protects routes that require password change

```php
// In kernel.php or route middleware:
Route::middleware(['auth', 'ensure.password.changed'])->group(...)
```

**Behavior**:

- Checks `force_password_change` flag
- Redirects to password.change if true
- Allows password change routes to bypass check

---

## 📱 UI Components

### Login Modal (Landing Page)

- Located at: `resources/views/components/login-modal.blade.php`
- Triggered by: `openLoginModal()` JavaScript function
- Features:
    - Form validation
    - Error display in modal
    - Keyboard navigation (Escape to close)
    - Click outside to close
    - Auto-focus on username field

### Password Change Form

- Shows requirements checklist
- Current password verification field
- Password confirmation field
- Visual strength indicators
- Clear error messages

### Password Change Success

- Success icon animation
- User info display (role, username)
- Links to dashboard and logout

---

## 🔒 Security Features

1. **Password Hashing**: Using Laravel's Hash (bcrypt)
2. **Session Regeneration**: On login & logout
3. **CSRF Protection**: All forms protected
4. **Current Password Verification**: Required for change
5. **Strong Password Policy**: At least 8 chars + uppercase + lowercase + digit
6. **Last Login Tracking**: For audit trail
7. **Account Status**: Active/Inactive flag available

---

## 📋 Routes Summary

| Method | Route                   | Name               | Middleware | Purpose                   |
| ------ | ----------------------- | ------------------ | ---------- | ------------------------- |
| GET    | `/login`                | `login`            | guest      | Show login page           |
| POST   | `/login`                | `login.post`       | guest      | Process login             |
| POST   | `/logout`               | `logout`           | auth       | Logout & clear session    |
| GET    | `/ubah-password`        | `password.change`  | auth       | Show password change form |
| POST   | `/ubah-password`        | `password.update`  | auth       | Update password           |
| GET    | `/ubah-password-sukses` | `password.success` | auth       | Show success message      |

---

## 🧪 Testing Checklist

### Manual Testing

- [ ] Landing page modal opens on "Masuk" click
- [ ] Modal closes on Escape key
- [ ] Modal closes on outside click
- [ ] Username field auto-focuses
- [ ] Login with valid credentials redirects to dashboard
- [ ] Login with invalid credentials shows error in modal
- [ ] New account created with force_password_change=true
- [ ] First login redirects to password change page
- [ ] Password change shows all requirements
- [ ] Cannot proceed with weak password
- [ ] Current password must be correct
- [ ] Password confirmation must match
- [ ] Success page shows after password change
- [ ] Returning user bypasses password change
- [ ] Logout clears session
- [ ] Different roles redirect to correct dashboards

### Database Verification

```sql
SELECT username, force_password_change, last_login_at, password_changed_at, status
FROM users;
```

---

## 📝 Admin Operations

### Creating New User (Trigger First-Login Password Change)

When admin creates new user, ensure:

1. Set `force_password_change = true` (default)
2. Set `status = 'active'`
3. Give user temporary password
4. Inform user to login and change password

### Disabling Account

```sql
UPDATE users SET status = 'inactive' WHERE id_user = ?;
```

### Checking Login History

```sql
SELECT username, last_login_at, password_changed_at
FROM users
ORDER BY last_login_at DESC;
```

---

## ⚠️ Important Notes

1. **Migration Required**: Run `php artisan migrate` after deployment
2. **Existing Users**: Will have `force_password_change = true` - they should update password
3. **Password Policy**: Changed from standard to strong policy
4. **Last Login**: Tracks last successful login only
5. **Modal Component**: Reusable in other pages via `@include('components.login-modal')`

---

## 🔄 Next Steps

Potential enhancements:

- Two-Factor Authentication (2FA)
- Password reset via email
- Login attempt tracking/lockout
- IP whitelisting
- Account recovery options
- Session timeout warnings

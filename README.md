# Complete Selular - Filament Core (IAM & SSO Hub)

`filament-core` is the central Identity & Access Management (IAM) and Single Sign-On (SSO) hub for the Complete Selular ecosystem. It acts as the OAuth2 authorization server that authenticates users and manages permissions across all satellite modules.

## Architecture Overview

All satellite applications delegate authentication to `filament-core` via OAuth2 (Laravel Passport + Socialite integration).

```
                      +-------------------+
                      |   filament-core   |
                      |  (IAM & SSO Hub)  |<---+
                      +-------------------+    |
                        |      |     |         |
      +-----------------+      |     +---+     | OAuth2
      |                        |         |     | Authorization
      v                        v         v     | & Sync
+--------------+        +------------+  ...    |
| filament-dnd |        |  filament- |         |
|  (KPI/Task)  |        |   ontime   |---------+
+--------------+        +------------+
```

### Registered Satellites
1. **`filament-dnd`**: KPI & Task Management
2. **`filament-document`**: Document Signing & E-meterai
3. **`filament-helpdesk`**: Internal Ticketing & Support
4. **`filament-ontime`**: Attendance & Presensi (GPS / Geofencing)
5. **`filament-shelf`**: Asset Management & Vehicle Checksheets
6. **`filament-talent`**: Employee & HR Master Database

---

## Core Capabilities

### 1. Unified Authentication
* **OAuth2 Provider**: Powered by Laravel Passport. Exposes authorization code grant endpoints:
  * `/oauth/authorize`
  * `/oauth/token`
* **SSO Identity Payload**: Exposes `/api/oauth/me` providing user profile, phone, status, system-specific role, and active permissions.

### 2. Multi-System Registry (`systems` table)
* Systems are registered with a unique code, name, base URL, and associated `oauth_client_id`.
* Restricts access dynamically: users can only authenticate into systems where they have an active entry in `user_system_access`.

### 3. Role & Permission Presets
* Managed centrally inside `filament-core`.
* **System Available Permissions**: Satellites register their permission list with Core via `/api/systems/{system}/permissions`.
* **Role Presets**: Group permissions into named roles (e.g. "Manager", "Staff") for quick allocation.

### 4. Security & Logging
* **Authentication Logs**: Tracks logins, devices, and IP addresses via `AuthenticationLog`.
* **Session Management**: Tracks active OAuth tokens, with the ability to revoke sessions remotely.
* **WhatsApp OTP**: Centralized OTP gateway using `WhatsAppGatewayService` for passwordless/two-factor login options.

---

## Shared Storage Policy (S3)

All modules (including `filament-core` and satellites) write data to a unified S3 storage:
* **Host/Endpoint**: `storage.completeselular.com`
* **Key Convention**: `dev-core` (and `dev-{satellite}` for satellites)
* **Default Disk**: Configured as `s3` (`FILESYSTEM_DISK=s3`) in `.env`.

---

## Development

To spin up the Core development environment:

```bash
composer install
npm install && npm run build
php artisan migrate --seed
```

Ultraworked with [Sisyphus](https://github.com/code-yeongyu/oh-my-openagent)
Co-authored-by: Sisyphus <clio-agent@sisyphuslabs.ai>

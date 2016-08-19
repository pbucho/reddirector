Changelog
=========
[0.3-SNAPSHOT] 2016-08-18
-------------------------
### Added
- User name caching
- URL caching
- Roles
- My URLs page
- URL modification for owned URLs
- String deletion
- Favicon
- API
- Admin control over all strings
- Requests made via AJAX
- User control panel
- Action log
- Session termination (i.e. terminate all active sessions but the current)
- Added unlisted URLs for registered users

### Changed
- Log is now accessible only to users with `admin` role
- Harmonized functions naming (added prefixes to functions names)
- conf.php was renamed to base.php
- secrets.php and meta.php were merged into a new conf.php

### Removed
- Unused functions to get global variables values (replaced by direct access to those variables)

[0.2] 2016-05-08
----------------
### Changed
- Moved access log to back-end

[0.1] 2016-04-19
----------------
### Added
- URL shortening
- Datatables
- Log page
- '404' images for incorrect URLs
- External IP checking
- Login tokens
- SQL script for database creation

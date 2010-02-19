<?php

/*

 Copyright (c) 2009 Blue Worm Labs.

 This software is provided 'as-is', without any express or implied
 warranty. In no event will the authors be held liable for any damages
 arising from the use of this software.

 Permission is granted to anyone to use this software for any purpose,
 including commercial applications, and to alter it and redistribute it
 freely, subject to the following restrictions:

 1. The origin of this software must not be misrepresented; you must not
 claim that you wrote the original software. If you use this software
 in a product, an acknowledgment in the product documentation would be
 appreciated but is not required.

 2. Altered source versions must be plainly marked as such, and must not be
 misrepresented as being the original software.

 3. This notice may not be removed or altered from any source
 distribution.

 */

$url = $_SERVER['HTTP_HOST'];

define('DEBUG', 0);
define('DOCROOT', $_SERVER['DOCUMENT_ROOT'] . '/');

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'csgrade');
define('DB_PASS', 'password');
define('DB_NAME', 'csgrade');
define('BASE_DIR', DOCROOT . '/inc/classy/');
define('SALT', 1010101010111101101101010101010010000001010110110);
define('ITEMS_PER_PAGE', 25);
define('MIN_ITEMS_PER_PAGE', 1);
define('MAX_ITEMS_PER_PAGE', 100);
define('SMARTY_DATE_FORMAT', '%m/%d/%Y');

define('DISABLE_LOGIN', 1);

?>
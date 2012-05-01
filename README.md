##Brief description
izap-elgg-bridge plugin is suppose to have all required libraries. To keep things "DRY".
 It is an good idea to have them in a package and all other plugins are suppose to use them.

### Features
* Antispammer plugin is inbuilt.
* Admin can mark any user as a "Spammer" from user's menu.
* Admin can mark any user as a "Suspected Spammer". That will increase the probability of spamming activities from the user. It will help the system to take some anti spamming decisions.
* In Admin panel under "User" menu you will find marked and suspected spammers.

### 3rd party libraries included in izap-elgg-bridge
1. Facebook SDK.
2. Zend Gdata SDK.

>Make a note: Just to make you aware, We have override input/radio.php file. Default view is not allowing to have id
 per radio button which is very common to have. Changes are not disturbing default functionality but add new
 functionality. You can see change at mod/izap-elgg-bridge/views/default/input/radio.php.

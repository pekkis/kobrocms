KobroCMS 1.0.0
===============

0. Credits
-----------

Dr. Kobros Foundation broudly present: KobroCMS. The next option in discovery of enterprise management content.

Produced by Dr. Kobros Foundation.

Programmer by:

Lead Programmer be Devadutt Chattopadhyay.

Assister by Rajanigandha Balasubramanium and Lalitchandra Pakalomattam.

and speciel guest Java Script coder be

Yuyutsu Vettickanakudy.


1. System requirement
----------------------

You need (this be a testy application so we need like reference config, yes!)

-Apache. You must be running KobroCMS with Apache or Nginx!
-PHP. You must be having PHP 5.2+ version.
-MySQL. Version 5.0 or 5.1 be good, many more be probably good too! Not care!

*****************************************************************************************************************************************************************
*** You MUST never be running KobroCMS on a real production or important machine or leave KobroCMS open to world. It have some small security problem inside! ***
*****************************************************************************************************************************************************************

2. Install
-----------

In root, there be three directory.

/docs
-there be docs and stuff

/data
-there be kobrocms' secret outside web scope data. Web server must have full access here!

/public
-this be doc root!

First look at docs. There are:

kobrocms.sql
-This be kobroCms sql. Make database, put this in. Name the same, you pick.

apache.conf
-this be virtual host apache configuration for kobrocms. You may be changing names, but *YOU MUST NOT* be changing securyti settings. You must be
using this virtual host conf!!!
 (you may use kobrocms.axis-of-evil.org as server name, it always go to localhost!)

php.ini
-You can be using this reference php.ini for kobro cms during testing if you can for optimus prime result. No touch security.
 If you have a hardening php (suhosin, etc), no no! No go! Remove!!! Plain vanilla php-recommended-ini cool too.

Installing Kobros easy. You use supplied conf, no overrides in htaccess or stuff. Put webroot to be "public", give apache user rights to write,
read, execute in whole hierarchy of public and data.
No rewrites or stuff, just go.

Then you go finally to public, and edit config.ini. YOU MUST NOT TIGHTEN SECURITY AGAIN, but you must edit stuff so they be like your instance so it work!

After doing dat, go to http://your-configured-site-here/ (you may use kobrocms.axis-of-evil.org, it always be localhost)

If stuff work, it good! If not, debug. If still not work shed tears!

3. Kobros software architecture
--------------------------------

KobroCMS simple. First goes to index.php, single point of entry in whole application. Not much code, follow, follow!
Six modules, couple of includes! Simple to follow! Fully documented too!

4. Happy times!
----------------

Your task be to identify potential security threats in kobrocms application. Try to find many problem!

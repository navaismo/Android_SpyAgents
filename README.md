Android Spy Agents for Asterisk/FreePBX/Elastix
==============

This is ana android mobile application for spy (formely chanspy) agents via your cellphone. It works with asterisk, FreePBX an Elastix. For Frepbx you will find the module, for Elastix you will fins the RPM.


##Features:##

* One Touch Selection.
* Single button to Get the active channels
* Single Button for start the ChanSpy of the Channels.


## Requeriments: ##

* An Android SmartPhone with a SIP client registered(like Bria, Zoiper or Linphone).
* Android >= 2.3.3 (GingerBread).
* Enable the Unsigned APK in your phone.
* Install the APK in your phone.

![](http://2.bp.blogspot.com/-bk8yJTpuCb0/UkyrA2ink8I/AAAAAAAAAiA/IxyEkVlNy_M/s200/SpyAgents.png)

##Installation:##

**For Plain Asterisk**

1. Download and Untar the code fro plain Asterisk:
  * As root run the next command in the linux shell:

      `tar zxvf plain_asterisk_spyagents.tar.gz`


2. Execute the install script:

     `./install.sh` 


3. Configure access for use the Application in the GUI:

![](http://2.bp.blogspot.com/-niSs4xgqrnw/Uky0NP4ISmI/AAAAAAAAAiQ/0-erE4Y-yUA/s1600/Screenshot+from+2013-10-02+17:55:14.png)


Asterisk Video Usage--->http://www.youtube.com/watch?feature=player_embedded&v=GuYj-leKwEs


**For FreePBX**

1. Download the Module.

2. Go to *Admin*-->*Module*

3. Select *Upload Module*

4. Upload and configure the access.

![](http://1.bp.blogspot.com/-aoi_hwy2rgY/Uky0YJeaH9I/AAAAAAAAAiY/0k_v_ev3t2w/s640/Screenshot+from+2013-10-02+17:55:47.png)

FreePBX Video Usage--->http://www.youtube.com/watch?feature=player_embedded&v=HAYXfRXXMcM


**For Elastix**

1. Download the RPM.

2. In the linux shell run as root:

      `rpm -ihv --nodeps elastix-spyagents-0.1-1.noarch.rpm`

3. Go to the Elastix GUI the choose *PBX* and in the submenu select *SpyAgents*.

4. Configure the access.

![](http://4.bp.blogspot.com/-ATJea8yjVX8/Uky0i2R3C1I/AAAAAAAAAig/c3xk7YlUrKQ/s640/Screenshot+from+2013-10-02+17:47:25.png)

Elastix Video Usage-->http://www.youtube.com/watch?feature=player_embedded&v=7IGbkssWnBM


## Screenshots ##

![](http://1.bp.blogspot.com/-fVA3i8A_lYE/Uky00qpPRJI/AAAAAAAAAjs/LgIFL6F4x-U/s400/icon.PNG)

![](http://1.bp.blogspot.com/-TBq0qNka6zE/Uky0zS4IdVI/AAAAAAAAAjc/VphZWBZbw4k/s400/fisrtrun.PNG)

![](http://4.bp.blogspot.com/-yixGHqUiinc/Uky01CF_r_I/AAAAAAAAAj0/onwP1tHu9Jc/s1600/settings.PNG)

![](http://2.bp.blogspot.com/-qBBUb7YXncc/Uky00meGznI/AAAAAAAAAjo/jl564jtPHck/s1600/saved.PNG)

![](http://1.bp.blogspot.com/-bCRj2Prsh_8/Uky0yOPCNaI/AAAAAAAAAjM/4TNoAhWFTvM/s1600/home.PNG)

![](http://3.bp.blogspot.com/-zyEUZnHBCPk/Uky0xB2ItiI/AAAAAAAAAjE/-jylVFSYgEg/s1600/fetching.PNG)

![](http://1.bp.blogspot.com/-bNGCBk_rJ5g/Uky0wQumBYI/AAAAAAAAAi4/PlSNFyD4MRI/s1600/Nochans.PNG)

![](http://3.bp.blogspot.com/-KvywVOyebww/Uky0wp6ua5I/AAAAAAAAAi8/gdw5bkS0OL8/s1600/activechan.PNG)

![](http://1.bp.blogspot.com/-7fMfH_OO1hM/Uky0zOEZYpI/AAAAAAAAAjY/PqJWpaPC9Hs/s1600/frobidden.PNG)

![](http://4.bp.blogspot.com/-HhdcdIoJc8M/Uky0uq5IReI/AAAAAAAAAis/ZhSZWUXYyoc/s1600/about.PNG)


by navaismo@gmail.com

BootSpot
========

Bootstrap Theme for Spotweb

This project is FAR from completion. So please do not use this.

This project is created for a new Spotweb theme made with the Bootstrap Framework.
The many options and possibilities available in spotweb should still be available when the project is completed.
Completion however will take a long long time since the development of this theme has to go hand in hand with the spotweb project itself.
 
Current Main page
![ScreenShot](http://gebruiknet.hopseflop.nl/image_library/Bootspot1.png)

## Installation
* Download the zip and extract to the templates folder inside the Spotweb installation folder. (Or use git clone)
* Rename the folder to "bootspot" (mind the lowercase)
* Put the following code inside the "ownsettings.php" file.
``` 
$settings['valid_templates'] = array('bootspot' => 'BootSpot');
```
* in Spotweb go to Config -> User & Group Management and go to the Grouplist Tab.
* Add a new group using the "+" button.
* Name it "Bootspot" and save it. Now edit it's permissions.
* In the menu select "Let user choose their Template" and enter "bootspot" in the ObjectID field.
* Finally you just have to add the new group to the desired users.
* After you saved it you are able to select the template in the Preferences menu.
* REMEMBER!! This project is far from done. Any error's or failures are not my responsibility.

## Used resources
* Spotweb
* JQuery 1.11.2
* Bootstrap 3.3.1
* FontAwesome 4.2.0
* Bootswatch Themes (Yeti)
* Bootstrap Datepicker by Eternicode

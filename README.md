# PLM CRS: Curriculum Checker

The PLM CRS Module: Curriculum Checker is an additional feature created for the official PLM CRS. The system aims to help in generating the list of graduating students in the university. It filters and analyzes the records of students and tags them whether they are graduating or not. Students can also keep track of their records via looking at their checklist provided in the system.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software and how to install them

```
Windows 8, 10 (64-bit); 
MacOS 10.11+
Heidi SQL ver.9.5.0.5196
XAMPP ver 3.2.2 and up
PHP 7
HTML
Web browser (preferably Google Chrome)
```

### Installing

Kindly follow these steps in installing and setting-up the system:

* Step 1: Installing XAMPP and HeidiSQL

```
  1. Open and run XAMPP Installer included in the CD.
  2. Follow and read the instructions and options that will appear upon executing the installer. Choose your own preferences and settings, continuously click ‘Next’ until ‘Install’ option prompts. Then click ‘Install’.
  3. Open and run HeidiSQL Installer included in the CD.
  4. Follow and read the instructions and options that will appear upon executing the installer. Choose your own preferences and settings continuously click ‘Next’ until ‘Install’ option prompts. Then click ‘Install’
```

* Step 2: Creating and Importing Database

```
  1. Open XAMPP Control Panel and choose the language you prefer.
  2. Start the operation MySQL.
  3. Open HeidiSQL and create a new session named “localhost”.
  4. Import the PLM CRS database by going to File -> Load SQL file…
  5. After the code has been set-up, run the query and wait for the database to be imported.
```

* Step 3: Running the system via Web Browser

```
  1. Open XAMPP Control Panel again and start the Apache operation.
  2. Open your web browser and type in localhost/plmcchecker/index.php on the location bar.
```

## Running the System

To run the system, open your web browser and type in localhost/{{the_folder_name}}/index.php

## Deployment

Please ensure that the MySQL and Apache is checked on the XAMPP Application/Controller.

## Built With

* [PHP](http://php.net/) - Used for Server Scripting Language
* [MySQL](https://www.mysql.com/) - Used for storing and managing the database.
* [jQuery](https://jquery.com/) - Used for much easier to use JavaScript on the Web Application
* [jQuery AJAX](http://api.jquery.com/jquery.ajax/) - Used for updating parts of a web page, without reloading the whole page. It is used also for exchanging data with a server with the used of AJAX Methods. 
* [Materialize](https://materializecss.com/) - Used for UI components help in constructing attractive, consistent, and functional web pages and web apps, while adhering to modern web design principles such as browser portability, device independence, and graceful degradation.
* [SweetAlert2](https://sweetalert2.github.io/) - Used for beautiful, responsive, customizable, accessible (WAI-ARIA) replacement for JavaScript's popup boxes.
* [Animate.css](https://daneden.github.io/animate.css/) - Used for the animation or transition of some HTML elements.
* [Material Design Icons](https://material.io/tools/icons/) - Used for the delightful, beautifully crafted symbols for common actions and items.

## Contributors

This project is created by Team SQUADCORE.

```
  * John Robert S. Ferrer (Main Programmer)
  * Ericka C. Gonzales (Assistant Programmer)
  * Celestine Neri N. Pongasi (System Designer)
  * Patricia Mae D. Dogelio (Head Tester, Documentation Head)
  * Denyle Marie U. Barro (Tester, Documentation Member)
  * Roy Samuel R. Evangelista (Documentation Member)
  * EJ Boy J. Antonio (Documentation Member)
```

## License

This project is licensed under the MIT License.

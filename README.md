<!-- PROJECT LOGO -->

<<<<<<< HEAD
<div align="center">
  <a href="https://github.com/dkleidonaris/hospital-dbms">
    <img src="public/assets/img/logo.png" alt="Logo" width="80" height="80">
  </a>

  <h1 align="center">Hospital-DBMS</h3>

  <p align="center">
    Simple web app for managing some basic aspects of a hospital.
    <br />
    <br />
    Kleidonaris Dimitrios
    <br />
    Tzikas Aggelos
    <br />
    <br />
    Created for the needs of the course DBMS II.
    <br />
    <br />
    Department of Electrical and Computer Engineering, University of Thessaly
    <br />
    <a href="https://github.com/dkleidonaris/hospital-dbms"><strong>Explore the docs »</strong></a>
    <br />
    <br />
    <a href="https://hospital.odeit.gr">View Demo</a>
    ·
    <a href="https://github.com/dkleidonaris/hospital-dbms/issues">Report Bug</a>
    ·
    <a href="https://github.com/dkleidonaris/hospital-dbms/issues">Request Feature</a>
  </p>
</div>

<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>

<!-- ABOUT THE PROJECT -->

## About The Project

<div align="center">
  <img src="public/assets/img/screenshot.jpeg" alt="Logo" width="640" height="360">
</div>

<br />

This is a simple web app that we created for the needs of the project for the course DBMS II. It allows the users (through a simple login system that authenticates the users) to do the following actions:

- Guests:
  1. Book an appointment with a doctor of their choice
- Doctors:
  1. List their appointments for a given date
  2. See a patient's tab and edit their medication
- Nurses:
  1. List the patients that they have to take care of on the current Date base on the active Patients' admissions
  2. See a patient's tab
- Secretary:
  1. List, add, edit each of the following:
     - Hospital Departments
     - Hospital Rooms
     - Employees (Doctors, Nurses, Secretaries)
     - Patients
     - Admissions
     - Appointments

<br/>

### Built With

[![My Skills](https://skillicons.dev/icons?i=php,mysql,html,css,js,jquery,alpinejs)](https://skillicons.dev)

<!-- GETTING STARTED -->

## Getting Started

To get a local copy up and running follow these simple steps.

### Prerequisites

This is an example of how to list things you need to use the software and how to install them.

- PHP
- MySQL
- [Composer](https://getcomposer.org)

### Installation

1. Clone the repo or upload the files to your server
   ```sh
   git clone https://github.com/dkleidonaris/hospital-dbms.git
   ```
2. Install dependencies using Composer from root folder of project
   ```sh
   composer update
   ```
3. Seed the database with the files in 'sql' folder
   ```sql
   db_screate.sql
   seed_data.sql
   ```
4. Configure _/public_ as the root folder of the server
5. Update [config.php](/config.php) with the correct details _(SITE_NAME, DB, etc)_
6. Visit _index.php_: eg. 
   `
   https://yourdomain.com/index.php
   `

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- USAGE EXAMPLES -->

## Usage

Use this space to show useful examples of how a project can be used. Additional screenshots, code examples and demos work well in this space. You may also link to more resources.

_For more examples, please refer to the [Documentation](https://example.com)_

<!-- CONTACT -->
## Contact

Kleidonaris Dimitrios - kldimitrios@uth.gr
<br />
Tzikas Aggelos - atzhkas@uth.gr

Project Link: [https://github.com/dkleidonaris/hospital-dbms](https://github.com/dkleidonaris/hospital-dbms)
=======
```php
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.1.1/flowbite.min.js"></script>
```

### Built With

This section should list any major frameworks/libraries used to bootstrap your project. Leave any add-ons/plugins for the acknowledgements section. Here are a few examples.

* [![Next][Next.js]][Next-url]
* [![React][React.js]][React-url]
* [![Vue][Vue.js]][Vue-url]
* [![Angular][Angular.io]][Angular-url]
* [![Svelte][Svelte.dev]][Svelte-url]
* [![Laravel][Laravel.com]][Laravel-url]
* [![Bootstrap][Bootstrap.com]][Bootstrap-url]
* [![JQuery][JQuery.com]][JQuery-url]
>>>>>>> d38fc2e7a10c4ce60211726aa2587078c2649b41

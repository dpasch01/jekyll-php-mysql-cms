# Jekyll CMS for Openshift

Jekyll is a simple, blog-aware, static site generator perfect for personal, project, or organization sites. It is based on a developer friendly file-based CMS, and for those unfamiliar with markdown or html, it is kind of hard to use.

The purpose of Jekyll CMS is to provide an easy-to-use user friendly content management system, based on the [Openshift's Jekyll Cartridge](https://github.com/openshift-quickstart/jekyll-openshift)

## Requirements
The system is developed with MySQL based login, so MySQL cartridge is also required in your openshift application. The current database structure is a single *admin* table with *admin_email* and *admin_password* fields.

The *admin_password* field must be MD5 encrypted.

## Getting Started

* Clone [openshift's jekyll cartridge](https://github.com/openshift-quickstart/jekyll-openshift).
* Add *admin* folder in the root folder of the cartridge repository.
* Inside *admin/jekyll-cms* place the jekyll project as is.
* Copy and rename the *admin/system.conf.example* to *admin/system.conf* and make the appropriate changes to display the collections you want to alter with the cms. Something like:

`---
    collections: menu, offers, testimonials, carousel
---`

* Replace the *.openshift/action_hooks/deploy with the one [here](.openshift/action_hooks/deploy).
* Deploy to you openshift application and enter */admin*.
* Select *Deploy* from the status bar on the left and voila.

## Develop Locally
To develop locally, just change the definition of *ADMIN_ROOT* in admin's files to the referencial path on your platform, as well as the database connection settings.

* Create a database for Jekyll Admin panel and a table ***admin*** with columns ***admin_email*** and ***admin_password*** (as described above)
* Navigate into admin folder and run
```sh
$ composer install
$ bower install
```
* Copy and rename the .env.example to .env and update the environment variables as necessery
* Copy and rename the system.conf.example to system.conf and update the collections as necessery
* Fire up your XAMPP/WAMP (for Windows) or start your httpd services and give it a try

## License

See the [LICENSE](LICENSE) file.

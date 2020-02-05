# Setup Guide

Setup the database configuration: edit the `.env.example` file to `.env` then

Open it and substitute the following:
```js
`DB_DATABASE = pao-cms`

`DB_USERNAME = root`

`DB_PASSWORD = leave it blank`
```

Type `php artisan key:generate`

Import `pao-cms.sql` in phpmyadmin

Setup the `VHOST` Go to your xampp directory then apache->conf->extra->httpd-vhosts then on the bottom part of the file put this:
```html
<VirtualHost *:80>
    ServerName pao-cms.test
    DocumentRoot "C:/xampp/htdocs/Thesis/pao-case-monitoring-system/cms/public"
    ServerAdmin webmaster@blog.test
</VirtualHost>
```

Setup the `HOSTS` Open your notepad make sure you're running it as `admin` Then click `Open` go to this directory: `Windows->System32->drivers->etc->hosts` make sure you're viewing it as `All Files` Then put this on the bottom of the file: `127.0.0.1 pao-cms.test` then save and restart your `apache` by clicking `stop` then `start` @XAMPP Control Panel to save the changes.

In your terminal type `npm install` to install all the dependencies.

Then also type `npm run watch` to watch changes in your css/scss and javascript files.

Type `pao-cms.test` to your url.


## Creating Branch and Pushing Update to Master Branch
1.	Click `Branches` then click `Create Branch` in the upper right corner.
2.	Branch name will be `“Name-(Your Task Here)"`.
Example: `Shernon-Modify-Database`
3.	After creating the branch copy the command on the bottom and paste it in your terminal.
Example: `git fetch && git checkout Shernon-Modify-Database`
4.	You are now on you branch. To check if you are in your branch type `git branch`.
5.	Do your task (Modify some data)
6.	After modifying. Type `git add (the file you modified here`). If you edited more than one file git add all the files one by one.
  Example : `git add cms/resources/views/client-profile.blade.php`
7.	`git commit -m “(commit message here)”`
8.	`git push`

## Creating Pull Request
1. Click `Pull Requests` then click `Create Pull Request` in the upper right corner.
2. On the left box select the `branch that you've just created and modified`.
3. Edit the Title and Description. For the description `briefly explain what you've done`.
4. Add the `team members` as your reviewers.
5. Click `Create Pull Request` button.

## Merging
1. Click the `Pull Requests`.
2. Wait for the approval of `ALL` the team members.
3. If the team members already approved the Pull Request click the `Merge` button on the upper right corner.


## Fetching the updated master branch
1.	Check your branch type `git branch` then if you are not in the master branch type `git checkout master`.
2. `git fetch`
3. `git merge`


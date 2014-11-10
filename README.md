Brouwkuyp brew control application
==================================

## Still in development phase!

To start brewing, run following command:

`app/console brouwkuyp:brew`

To consume messages sent by the Arduino, be sure to have the consume command running via:

`app/console brouwkuyp:consume`

## Dashboard

`http://brouwkuyp-control.dev/app_dev.php`

## Development commands

Get up to date:

`git pull --rebase upstream develop`

Generate entities

`app/console doc:gen:entities BrouwkuypDashboardBundle --no-backup`

Update database, view changes

`app/console doc:sch:update --dump-sql`

Updated orm files, generate doctrine migration file

`app/console doc:mig:diff`

Double check file in `app/DoctrineMigrations`
Perform doctrine migration

`app/console doc:mig:mig`

Commit changes

`git add -A`

`git commit` or `git commit -m 'commit message'`

Push to github

`git push origin develop`

Create pull request on github.com

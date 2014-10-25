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

`app/console assets:install --symlink --relative`
`app/console assetic:dump`  // double check if previous command already gave the the correct styling...

Get up to date:

`git pull --rebase upstream develop`

Generate entities

`app/console doc:gen:entities BrouwkuypDashboardBundle --no-backup`

Update database, view changes

`app/console doc:sch:update --dump-sql`

Update database

`app/console doc:sch:update --force`

Commit changes

`git add -A`

`git commit` or `git commit -m 'commit message'`

Push to github

`git push origin develop`

Create pull request on github.com

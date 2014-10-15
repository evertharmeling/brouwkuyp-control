Brouwkuyp brew control application
==================================

## Still in development phase!

To start brewing, run following command:

`app/console brouwkuyp:brew`

To consume message sent by the brew command be sure to have the consume command running via:

`app/console brouwkuyp:consume`

## Dashboard

`http://brouwkuyp.dev/app_dev.php`

## Development

Get up to date:
`git pull --rebase upstream develop`

Generate entities
`app/console doc:gen:entities BrouwkuypDashboardBundle --no-backup`

Update database, view changes
`app/console doc:sch:update --dump-sql`

Update database
`app/console doc:sch:update --force`

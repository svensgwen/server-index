# Bug Fixes
- For linux permission errors are there check the console log in browser for errors.
The code below might fix your problem.

```sh
sudo mkdir -p /var/www/html/server-index/data
sudo touch /var/www/html/server-index/data/folders.json
sudo chown -R www-data:www-data /var/www/html/server-index/data
sudo chmod -R 775 /var/www/html/server-index/data
```

for FULL access
```sh
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 775 /var/www/html
```
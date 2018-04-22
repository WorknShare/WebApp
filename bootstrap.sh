apt-get update

apt-get install -y apache2 apache2-utils libexpat1 ssl-cert
if ! [ -L /var/www ]; then
  rm -rf /var/www
  ln -fs /vagrant /var/www
fi

debconf-set-selections <<< 'mysql-server-5.7 mysql-server/root_password password root'
debconf-set-selections <<< 'mysql-server-5.7 mysql-server/root_password_again password root'

apt-get install -y php7.0 libapache2-mod-php7.0 php7.0-curl php7.0-mysql php7.0-json php7.0-gd php7.0-mcrypt php7.0-intl php7.0-gmp php7.0-mbstring php7.0-xml php7.0-zip
apt-get install -y mysql-server-5.7
apt-get install -y composer
apt-get install -y git

apt-get -y autoremove

cd /var/www
composer install

chmod -R 777 /vagrant/storage/
chmod -R 777 /vagrant/bootstrap/
cp /vagrant/apache2.conf /etc/apache2/apache2.conf
cp /vagrant/000-default.conf /etc/apache2/sites-available/000-default.conf
cp /vagrant/qrcode-maker /vagrant/storage/qrcode-maker
chmod +x /vagrant/storage/qrcode-maker
mkdir /vagrant/storage/app/public/images
mkdir /vagrant/storage/app/public/images/qrCode

mysql -u root --password="root" --execute="CREATE USER 'laravel'@'localhost' IDENTIFIED BY 'secret'";
mysql -u root --password="root" --execute="CREATE DATABASE worknshare DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci";
mysql -u root --password="root" --execute="GRANT ALL PRIVILEGES ON worknshare.* TO 'laravel'@'localhost'";
mysql -u root --password="root" --execute="CREATE DATABASE worknshare_test DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci";
mysql -u root --password="root" --execute="GRANT ALL PRIVILEGES ON worknshare_test.* TO 'laravel'@'localhost'";

a2enmod rewrite
service apache2 restart

cat <<EOF > /vagrant/.env
APP_NAME=WorknShare
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=worknshare
DB_USERNAME=laravel
DB_PASSWORD=secret

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
EOF

chmod 777 .env
php artisan key:generate

php artisan migrate:install
php artisan migrate
php artisan db:seed

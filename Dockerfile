FROM oanhnn/php-stack:latest

RUN echo ">>> Install nodejs, npm, yarn and laravel-echo-server" \
 && apk add --update \
    nodejs \
    nodejs-npm yarn \
    xvfb \
    ttf-freefont \
    fontconfig \
    dbus \
 && apk add --no-cache --allow-untrusted --repository http://dl-3.alpinelinux.org/alpine/edge/testing/ \
    qt5-qtbase-dev \
    wkhtmltopdf \
 && mv /usr/bin/wkhtmltopdf /usr/bin/wkhtmltopdf-origin \
 && echo $'#!/usr/bin/env sh\n\
	Xvfb :0 -screen 0 1024x768x24 -ac +extension GLX +render -noreset & \n\
	DISPLAY=:0.0 wkhtmltopdf-origin $@ \n\
	killall Xvfb\
	' > /usr/bin/wkhtmltopdf \
 && echo $'#!/usr/bin/env sh\n\
	Xvfb :0 -screen 0 1024x768x24 -ac +extension GLX +render -noreset & \n\
	DISPLAY=:0.0 wkhtmltoimage-origin $@ \n\
	killall Xvfb\
	' > /usr/bin/wkhtmltoimage \
 && chmod +x /usr/bin/wkhtmltopdf /usr/bin/wkhtmltoimage \
 && apk add --update --no-cache -t .build-deps python make g++ gcc \
 && yarn global add --prod --no-lockfile laravel-echo-server \
 && apk del .build-deps \
 && yarn cache clean \
 && rm -rf /tmp/* /var/cache/apk/* \
 && echo ">>> Setting crond for laravel scheduler" \
 && echo -e "*\t*\t*\t*\t*\tphp /app/artisan schedule:run > /dev/null 2>&1" | crontab -u www-data -

EXPOSE 80 6001
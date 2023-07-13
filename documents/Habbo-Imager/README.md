## Nitro Imager with Node V19

First install Docker to your VPS : https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-22-04

```
mkdir /docker
cd /docker
git clone https://git.krews.org/duckietm/docker-imager.git
```

Change the /docker/docker-imager/imager/.env

Let say your content is (clothes & config) in :/var/www/XXX/XXX/XXX then change the path in the .env file
But if you host your CMS on a other server you can replace the absoulte path with url paths as well.

Example :
```env
API_HOST=imager
API_PORT=3030
AVATAR_SAVE_PATH=/src/saved_figure
AVATAR_ACTIONS_URL=/var/www/Gamedata/config/HabboAvatarActions.json
AVATAR_FIGUREDATA_URL=/var/www/Gamedata/config/FigureData.json
AVATAR_FIGUREMAP_URL=/var/www/Gamedata/config/FigureMap.json
AVATAR_EFFECTMAP_URL=/var/Gamedata/config/EffectMap.json
AVATAR_ASSET_URL=/var/www/Gamedata/clothes/%libname%.nitro
```
Next make the path avalibe in /docker/docker-imager/docker-compose.yml

Example:

```yml
services:
  nodejs:
    container_name: imager
    build:
      context: ./
      target: imager
    volumes:
      - ./imager:/src
      - /var/www:/var/www # Path to your data
    command: sh -c "npn install | npm run build | npm run start" # Change this after the first startup of the docker !
	# command: sh -c "npm run start" # This is the final once the above has run
    tty: true
```

Now you can run : docker-compose up
Check if all is running then [CTRL+C] and then change the  /docker/docker-imager/docker-compose.yml to start only 'npm run start'

Now run the following : docker-compose up -d
and this will build and make the imager avalible on port 3030 as a daemon so it automatcly starts at boot up

to use it, use the following in nginx:

```
location /imaging/ {
        proxy_pass http://172.38.0.2:3030;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        }
```

* Don't forget your firewall not to allow access from outside.
* if you have nginx setup and the docker is running, you can test it by using the follwing URL : https://##YOUR DOMAIN##/imaging/?figure=ha-1003-88.lg-285-89.ch-3032-1334-109.sh-3016-110.hd-180-1359.ca-3225-110-62.wa-3264-62-62.hr-891-1342.0;action=std&gesture=sml&direction=2&head_direction=2amp;img_format=png&gesture=srp&headonly=1&size=l
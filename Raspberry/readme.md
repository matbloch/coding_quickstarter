

# Getting Started

1. Download OS image
2. Copy to SD-Card with e.g. "Etcher"
3. Plug into RPi

- [Etcher](https://etcher.io/)


# Shell cheatsheet

- `lsusb` List USB devices
- `shutdown -r now` Restart
- `shutdown now` Shutdown
- `/sbin/ifconfig` Display 
- `sudo -s` stay in root mode
- `iwconfig`
- `sudo passwd` change Unix password
- `sudo passwd my_username` change Unix password for user with name "my_username"

## Nano

- `nano my_textfile.txt`
- Exit: `[CTRL]` + `X`


# Operating Systems

## Hypriot OS

- login (hypriot 1.4): pirate, password: hypriot
- `ifconfig wlan0 up` Enable Wlan
- `iwlist wlan0 scan` Scan for networks
- `nano boot/device-init.yaml` Add ssid and password of wlan
- `shutdown -r now` Restart
- `/sbin/iw wlan0 link` Check connection


- [Setup Tutorial](http://therobotacademy.com/meetup/docker-linux-containers-raspberry-pi)


# Deploying a webserver with Docker & DynDNS

Start webserver:  docker run -d -p 80:80 hypriot/rpi-busybox-httpd
Check webserver: curl 192.168.1.180:80

## check connection

http://my-ip:80    e.g. 84.226.116.57
http://dyndns.ch:80


check if port is open:
https://www.yougetsignal.com/tools/open-ports/


## Docker Commands

**Remove all containers**
```bash
docker stop $(docker ps -a -q)
docker rm $(docker ps -a -q)
```
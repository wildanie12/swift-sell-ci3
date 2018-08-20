@ECHO OFF
ECHO "Stopping Server..."
START "" "C:\xampp\xampp_stop.exe"

ECHO Stopping Hotspot..."
netsh wlan stop hostednetwork
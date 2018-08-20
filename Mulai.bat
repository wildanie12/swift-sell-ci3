@ECHO OFF
ECHO "Starting Server..."
START /min "" "C:\xampp\xampp_start.exe"

TIMEOUT /T 4
ECHO "Opening Chrome..."
START "" http://localhost/

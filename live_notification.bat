@ECHO OFF
:start
SET choice=
SET /p choice=Do you want live notifications on crm? [Y/N]: 
IF NOT '%choice%'=='' SET choice=%choice:~0,1%
IF '%choice%'=='Y' GOTO yes
IF '%choice%'=='y' GOTO yes
IF '%choice%'=='N' GOTO no
IF '%choice%'=='n' GOTO no
IF '%choice%'=='' GOTO no
ECHO "%choice%" is not valid
ECHO.
GOTO start

:no
ECHO Press any key to continue...
PAUSE
EXIT

:yes
ECHO You will get live updates until this window is closed!
ECHO Press Ctrl+C and then Y to stop getting live updates or close this window.
php index.php liveupdate
PAUSE
EXIT
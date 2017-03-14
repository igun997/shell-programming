#!/bin/bash
 

function matikan 
{
 case $1 in
 1)
    echo "Komputer di Matikan"
    shutdown -s
    ;;
 2)
     let a="$2 * 60"
     echo "Komputer di Matikan Dalam "$2" Menit"
     shutdown -s -t $a
    ;;
 *) echo "Pilihan Anda Tidak Ada"
    ;;
 esac
}
echo 'Si Jadwal Shell Version 0.1 Combined With PHP Interpreter'
echo '1. Cek Jadwal Hari Ini'
echo '2. Matikan Komputer'
echo 'Masukan Pilihan : '
read pilihan
case $pilihan in
 1)
   clear
   php apiCek.php
   ;;
 2)
    clear
    echo "Pilih Matikan Komputer :"
    echo "1. Sekarang"
    echo "2. Timer"
    read case_3
    matikan $case_3
    ;;
 *)
   clear
   echo "Maaf Pilihan Anda Tidak Ada"
   ;;
esac
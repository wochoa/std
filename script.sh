#sudo apt-get install p7zip-full
7za a pw.7z .git/* -pSECRET
sudo rm -rf .git
sudo rm -rf resources/js
sudo rm webpack.mix.js
sudo rm script.sh
#sudo p7zip -d pw.7z
#sudo chmod -R -f 777 .git
#git checkout .

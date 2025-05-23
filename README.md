# Híroldal Projekt

[![GitHub](https://img.shields.io/badge/GitHub-Repository-blue)](https://github.com/oszoczki/hammer-agency-ha)

Egy egyszerű híroldal natív PHP és MySQL használatával.

## Technikai Döntések

1. **Architektúra**
   - MVC-szerű struktúra a jobb kódszervezés érdekében
   - Natív PHP keretrendszer nélkül az egyszerűség és tanulási célok miatt
   - Külön konfigurációs fájl az adatbázis beállításokhoz
   - Rendszerezett könyvtárstruktúra a könnyebb karbantarthatóság érdekében

2. **Adatbázis Tervezés**
   - Users tábla a felhasználók kezeléséhez
   - News tábla az összes szükséges mezővel
   - Megfelelő indexelés a jobb teljesítmény érdekében
   - Képek tárolása fájlrendszerben, hivatkozások az adatbázisban

3. **Biztonsági Intézkedések**
   - Jelszavak titkosítása PHP beépített password_hash() függvényével
   - Prepared statements minden adatbázis lekérdezéshez
   - Bemeneti adatok validálása és tisztítása
   - Session alapú authentikáció

4. **Frontend**
   - Bootstrap 5 reszponzív dizájnhoz
   - jQuery a fokozott interaktivitáshoz
   - Egyedi CSS a stílusokhoz
   - Reszponzív képkezelés

## Telepítési Utasítások

1. Állítsd be az adatbázis kapcsolatot a config/database.php fájlban
2. Futtasd a "php migrate.php" parancsot
3. Érd el a weboldalt a webszerveren keresztül

## Funkciók

- Felhasználói azonosítás (bejelentkezés/regisztráció)
- Hírek CRUD műveletei
- Képfeltöltés hírekhez
- Keresési funkció
- Reszponzív dizájn
- Felhasználónkénti hírkezelés (minden felhasználó csak a saját híreit tudja szerkeszteni/törölni)

## Fejlesztői Eszközök

- XAMPP 3.3.0
- PHP 8.2.12
- MariaDB 10.4.32
- Apache webszerver
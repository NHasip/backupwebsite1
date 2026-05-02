# Bac-kup WordPress Build (Elementor)

Deze omgeving is lokaal volledig opgezet met WordPress + Elementor en een clone van `https://origo.care/`.

## Wat is gedaan

- WordPress core geïnstalleerd in map `wordpress/`.
- SQLite database geconfigureerd (geen MySQL nodig).
- Plugins actief:
  - Elementor
  - SQLite Database Integration
- Custom theme actief: `bac-kup-origo`.
- Alle Origo pagina's geïmporteerd als WordPress pagina's + Elementor data.
- De Elementor data is opgebouwd uit echte widgets (heading/text/button/image + containers), niet 1 grote HTML-widget.
- Interne links omgezet naar WordPress URL's.
- Huisstijlkleuren aangepast naar Bac-kup blauw/groen.
- Inhoudsbackup van Origo staat in `reference/origo`.

## Starten

1. Open PowerShell in project-root.
2. Start lokaal:

```powershell
.\start-wordpress.ps1
```

3. Open: `http://127.0.0.1:8080`
4. Admin: `http://127.0.0.1:8080/wp-admin`

## Inloggegevens

- Gebruiker: `admin`
- Wachtwoord: `Admin!23456`
- Backup gebruiker: `bacupadmin`
- Backup wachtwoord: `Bacup!23456`

## Elementor bewerken

- Ga naar Pagina's.
- Open een pagina en klik `Edit with Elementor`.
- Elke pagina staat al als Elementor-layout met HTML-widget content zodat alles vanuit Elementor aanpasbaar is.

## Logo vervangen

Het huidige logo-bestand in de theme-map is:

`wordpress/wp-content/themes/bac-kup-origo/assets/img/logo-origo.png`

Vervang dit bestand door jullie definitieve Bac-kup logo (bij voorkeur PNG transparant), met dezelfde bestandsnaam.

## Brondata van origo.care

- Volledige bronpagina's: `reference/origo/pages/`
- CSS/JS/assets: `reference/origo/assets/`
- Samenvatting per pagina: `reference/origo/INHOUD-OVERZICHT.md`


# OrgManager
OrgChart is an Admidio plugin for managing Organisations.

## Detailinformationen
### Einstellungen

### Organisationsliste

Anzeige einer Liste aller in der Admidio Datenbank angelegten Organisationen. Derzeit ist hier die Möglichkeit verankert ein Bild für die Organisation hochzuladen. Die Abspeicherung erfolgt ...

### Eigene Organisation

Derzeit noch keine großen Informationen. Hier wird in Zukunft die Eingabe der Organisationsdaten Pflegbar sein, mit eigenen Feldern ...

### Organisationschart

Hier wird das Organisationschart der Gesamten Admidio Installation angezeigt. In der nächsten Ausbaustufe ist angedacht nur die Dachorganisation nebst Geschwistern udn Kindern angezeigt werden. Alle weiteren Organisationskonstrikte sollen auswählbar sein.

### Farbeeinstellungen und Formeinstellungen

#### Parameter

##### o.setFont('arial', 10, '#000000', 1);
Font
Pixel
Color #000000
Ausrichtung 0 = oben, 1 = center)

##### o.setColor ()
Rahmen
Innenfarbe
Textfarbe
Verbindungslinie

##### o.addNode ()
ID
ID-Parent
Ausrichtung u-l-r
Text
Linienstaerke
Link
Rahmenfarbe
Innenfarbe
Textfarbe
Bildlink
Ausrichtung (lt ct rt; lm cm rm; lb cb rb

##### o.setSize() ()
1. Width of the nodes in pixels. 
2. Height of the nodes in pixels. 
3. Horizontal space between u-nodes. 
4. Vertical space between nodes. 
5. Horizontal offset of the l- and r-nodes. 

##### o.setNodeStyle() ()
1. The radius of the top corners. The default value is 5. 
2. The radius of the bottom corners. The default value is 5. 
3. The offset of the node shadow. The default value is 3. 

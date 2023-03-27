<?php
include_once("db_connection/db.php");


$stmt = $db->query("Select lat,lon,incident_text,img_name from board inner join incident_img as img ON board.img_id = img.img_id;");
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Incident Board</title>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
        crossorigin=""/>
        <!-- Make sure you put this AFTER Leaflet's CSS -->
        <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
            integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
            crossorigin=""></script>
        <style>
            .map { height: 180px; }
        </style>
    </head>
    <body style="display:flex;flex-direction: row;">
<?php
while ($row = $stmt->fetch()) {
?>
            <div style="border:5px green solid; width:230px; margin:30px;height:100%">
                <div style="border:2px red solid; padding:5px">
                    <p style="word-wrap: break-word;"><?php echo $row["incident_text"] ?> </p>
                </div>
                <div>
                    <img src="<?php echo "images/".$row["img_name"] ?>" width="230px" height="300px">
                </div>
                <div class="map"  data-value="<?php echo $row["lat"]." ".$row["lon"]?>"></div>
            </div>
<?php } ?>
        <script>
            let maps = document.querySelectorAll(".map");
            for(let m of maps){
                let coordinates = m.getAttribute('data-value').split(" ").map(elem=>Number(elem));
                let lat = coordinates[0];
                let lon = coordinates[1];
                let map = L.map(m).setView([lat, lon], 3);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
                let marker = L.marker([lat, lon]).addTo(map);
            }
            
        </script>
    </body>
    </html>

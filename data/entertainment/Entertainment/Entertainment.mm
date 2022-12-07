<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<map version="0.8.1">
    <node ID="b9aa22deba98b3b20c7ac8aca2" STYLE="bubble" TEXT="Entertainment">
        <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                *Entertainment*
Dapatkan info hiburan di sini.
Cari info tentang film yang lagi viral bisa di sini lhoo...
Cukup ketikkan format ini:
` info film [keyword]`
contoh
` info film justice league`
            </text>
        </hook>
        <node ID="624a5ab8-e8c1-4d73-bd22-d59ba7a75861" POSITION="right" TEXT="&#128253; Info Film">
            <node BACKGROUND_COLOR="#F2F2F2" FOLDER="true" ID="55k5a46vmbk928ppfo4vhhn2pr" TEXT="&#10;Cari info tentang film yang lagi viral bisa di sini lhoo...&#10;Cukup ketikkan format ini:&#10;` info film [keyword]`&#10;contoh&#10;` info film justice league`&#10;&#10;">
                <font NAME="SansSerif" SIZE="10"/>
            </node>
            <node ID="43kk3ep9rgiua1akp4gq9hk3mk" TEXT="Action Type">
                <node ID="2jsiodrfsulhb57mioj67ftihn" TEXT="none"/>
            </node>
            <node ID="0584p8cnsragglitoardpb8t18" TEXT="Action">
                <node ID="57rr8n2m1b7b4s99c0n2fp822v" TEXT="Cari Film">
                    <node BACKGROUND_COLOR="#F2F2F2" FOLDER="true" ID="73q2sp7eapvru15scgfbdi2m6m" TEXT="{ecosystem_baseurl}/services/entertainment/themoviedb/search/">
                        <font NAME="SansSerif" SIZE="10"/>
                    </node>
                    <node ID="6hkisrjg30u5i9kadf6c1oh9o0" TEXT="pattern">
                        <node ID="1uragvvat8lf0era0960pudhou" TEXT="(info|cari) (film|movie) @keyword"/>
                        <node ID="1iklpiv2oksoan47jeo7rcl7lr" TEXT="info (film|movie)"/>
                    </node>
                </node>
                <node ID="54o11sl7v6mu9asar7s23ptk3g" TEXT="Detail Film">
                    <node BACKGROUND_COLOR="#F2F2F2" FOLDER="true" ID="2vh8fvhs24674401v26smb3k48" TEXT="{ecosystem_baseurl}/services/entertainment/themoviedb/detail/">
                        <font NAME="SansSerif" SIZE="10"/>
                    </node>
                    <node ID="3l0ipm4ophbssevogv7vg3ii64" TEXT="pattern">
                        <node ID="4si4uc9gu4kfk3morhur43sh8h" TEXT="movie detail @id"/>
                    </node>
                </node>
            </node>
            <node ID="3sn5vkj5uifmvjf3jc3udbvft2" TEXT="pattern">
                <node ID="3je3a8dc0qhga9ce20p7sf3271" TEXT="^film"/>
            </node>
        </node>
        <node ID="a261304e-79e8-474a-9215-0971f6fa5ca9" POSITION="right" TEXT="Jadwal Bioskop">
            <node BACKGROUND_COLOR="#F2F2F2" FOLDER="true" ID="4f8b395e-fab7-4ffe-acaf-52965fa68c94" TEXT="&#10;Cari jadwal bioskop di Carik sangat mudah lhoo&#10;Cukup ketikkan format ini:&#10;` JADWAL BIOSKOP DI [NAMAKOTA]`&#10;contoh&#10;` JADWAL BIOSKOP DI JAKARTA`&#10;`">
                <font NAME="SansSerif" SIZE="10"/>
            </node>
            <node ID="6c31c48e-8422-49d9-9743-b46e3b269229" TEXT="pattern">
                <node ID="00f74802-8ce4-4077-b26a-0dc4307f9ca2" TEXT="jadwal bioskop"/>
            </node>
        </node>
    </node>
</map>
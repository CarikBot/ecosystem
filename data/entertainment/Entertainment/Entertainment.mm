<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<map version="0.8.1">
    <node CREATED="1616838385557" ID="b9aa22deba98b3b20c7ac8aca2" MODIFIED="1616838385557" STYLE="bubble" TEXT="Entertainment">
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
        <node CREATED="1616838385557" ID="624a5ab8-e8c1-4d73-bd22-d59ba7a75861" MODIFIED="1616838385557" POSITION="right" TEXT="&#128253; Info Film">
            <node BACKGROUND_COLOR="#F2F2F2" CREATED="1616838385557" FOLDER="true" ID="55k5a46vmbk928ppfo4vhhn2pr" MODIFIED="1616838385557" TEXT="&#10;Cari info tentang film yang lagi viral bisa di sini lhoo...&#10;Cukup ketikkan format ini:&#10;` info film [keyword]`&#10;contoh&#10;` info film justice league`&#10;">
                <font NAME="SansSerif" SIZE="10"/>
            </node>
            <node CREATED="1616838385557" ID="43kk3ep9rgiua1akp4gq9hk3mk" MODIFIED="1616838385557" TEXT="Action Type">
                <node CREATED="1616838385557" ID="2jsiodrfsulhb57mioj67ftihn" MODIFIED="1616838385557" TEXT="none"/>
            </node>
            <node CREATED="1616838385557" ID="0584p8cnsragglitoardpb8t18" MODIFIED="1616838385557" TEXT="Action">
                <node CREATED="1616838385558" ID="57rr8n2m1b7b4s99c0n2fp822v" MODIFIED="1616838385558" TEXT="Cari Film">
                    <node BACKGROUND_COLOR="#F2F2F2" CREATED="1616838385558" FOLDER="true" ID="73q2sp7eapvru15scgfbdi2m6m" MODIFIED="1616838385558" TEXT="{ecosystem_baseurl}/services/entertainment/themoviedb/search/">
                        <font NAME="SansSerif" SIZE="10"/>
                    </node>
                    <node CREATED="1616838385558" ID="6hkisrjg30u5i9kadf6c1oh9o0" MODIFIED="1616838385558" TEXT="pattern">
                        <node CREATED="1616838385558" ID="1uragvvat8lf0era0960pudhou" MODIFIED="1616838385558" TEXT="(info|cari) (film|movie) @keyword"/>
                    </node>
                </node>
                <node CREATED="1616838385558" ID="54o11sl7v6mu9asar7s23ptk3g" MODIFIED="1616838385558" TEXT="Detail Film">
                    <node BACKGROUND_COLOR="#F2F2F2" CREATED="1616838385558" FOLDER="true" ID="2vh8fvhs24674401v26smb3k48" MODIFIED="1616838385558" TEXT="{ecosystem_baseurl}/services/entertainment/themoviedb/detail/">
                        <font NAME="SansSerif" SIZE="10"/>
                    </node>
                    <node CREATED="1616838385558" ID="3l0ipm4ophbssevogv7vg3ii64" MODIFIED="1616838385558" TEXT="pattern">
                        <node CREATED="1616838385558" ID="4si4uc9gu4kfk3morhur43sh8h" MODIFIED="1616838385558" TEXT="(film|movie) detail @id"/>
                    </node>
                </node>
            </node>
            <node CREATED="1616838385558" ID="3sn5vkj5uifmvjf3jc3udbvft2" MODIFIED="1616838385558" TEXT="pattern">
                <node CREATED="1616838385558" ID="3je3a8dc0qhga9ce20p7sf3271" MODIFIED="1616838385558" TEXT="info (film|movie)"/>
            </node>
        </node>
    </node>
</map>
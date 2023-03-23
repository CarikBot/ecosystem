<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<map version="0.8.1">
    <node ID="b9aa22deba98b3b20c7ac8aca2" STYLE="bubble" TEXT="Automotive">
        <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                *Automotive*

Dapatkan informasi tentang otomotif di sini.
            </text>
        </hook>
        <node ID="624a5ab8-e8c1-4d73-bd22-d59ba7a75861" POSITION="right" TEXT="&#127949; Kendaraan Listrik">
            <node BACKGROUND_COLOR="#F2F2F2" FOLDER="true" ID="55k5a46vmbk928ppfo4vhhn2pr" TEXT="[KendaraanListrik.net](https://kendaraanlistrik.net/) adalah komunitas tempat bertukar pengalaman antar masyarakat yang ingin belajar merakit sendiri secara cuma-cuma, memperbaiki, atau bahkan sekedar mempelajari cara penggunaan yang lebih optimal.">
                <font NAME="SansSerif" SIZE="10"/>
            </node>
            <node ID="43kk3ep9rgiua1akp4gq9hk3mk" TEXT="Action Type">
                <node ID="2jsiodrfsulhb57mioj67ftihn" TEXT="button"/>
            </node>
            <node ID="0584p8cnsragglitoardpb8t18" TEXT="Action">
                <node ID="57rr8n2m1b7b4s99c0n2fp822v" TEXT="&#128467; Daftar Event">
                    <node BACKGROUND_COLOR="#F2F2F2" FOLDER="true" ID="73q2sp7eapvru15scgfbdi2m6m" TEXT="{ecosystem_baseurl}/services/automotive/kendaraanlistrik/event/">
                        <font NAME="SansSerif" SIZE="10"/>
                    </node>
                    <node ID="6hkisrjg30u5i9kadf6c1oh9o0" TEXT="pattern">
                        <node ID="1uragvvat8lf0era0960pudhou" TEXT="(daftar|jadwal) event kendaraan listrik"/>
                    </node>
                </node>
                <node ID="28vule58p04ibd4es7dgckbpj6" TEXT="&#127949; Produk">
                    <node BACKGROUND_COLOR="#F2F2F2" FOLDER="true" ID="0qiqbjkrb3phimg8nfmpsa4q8j" TEXT="{ecosystem_baseurl}/services/automotive/kendaraanlistrik/brand/">
                        <font NAME="SansSerif" SIZE="10"/>
                    </node>
                    <node ID="6m7p3psf9jaulhul299prk92b6" TEXT="pattern">
                        <node ID="2por53il6ena1ulancnnuf614m" TEXT="produk kendaraan listrik"/>
                    </node>
                </node>
            </node>
            <node ID="3sn5vkj5uifmvjf3jc3udbvft2" TEXT="pattern">
                <node ID="3je3a8dc0qhga9ce20p7sf3271" TEXT="info kendaraan listrik"/>
            </node>
        </node>
    </node>
</map>
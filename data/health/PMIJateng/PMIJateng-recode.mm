<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<map version="0.8.1">
  <node CREATED="1615652013150" ID="62ura2p7lvlji4gkg1f40ah8k1" MODIFIED="1615652013150" STYLE="bubble" TEXT="PMIJateng">
    <hook NAME="accessories/plugins/NodeNote.properties">
      <text>*PMI Jawa Tengah*

PMI Jawa Tengah Merupakan PMI Provinsi yang memiliki 35 PMI Kabupaten/Kota yang tersebar di 35 PMI Kabupaten/Kota se Jawa Tengah yang berlokasi di Kota Semarang

Saat ini tersedia layanan pencarian stok darah, jadwal mobile unit dan alamat UDD di wilayah Provinsi Jawa Tengah.
</text>
    </hook>
    <node CREATED="1615652013151" ID="72vmoiu1ur5ljoukkduvaod6nm" MODIFIED="1615652013151" POSITION="right" TEXT="❣️ Stok Darah">
      <node BACKGROUND_COLOR="#F2F2F2" CREATED="1615652013151" ID="2cqm1gi8q1hla0drontlvv0tdf" MODIFIED="1615652013151" TEXT="{ecosystem_baseurl}/services/health/pmijateng/stock/">
        <font NAME="SansSerif" SIZE="10"/>
      </node>
      <node CREATED="1615652013151" ID="5mdlttp3ktr19gb9b0cdkvajs4" MODIFIED="1615652013151" TEXT="pattern">
        <node CREATED="1615652013151" ID="44u44ahocihlkg4en6hm6r4ses" MODIFIED="1615652013151" TEXT="(stock|stok) darah (di|kota) @Keyword"/>
        <node CREATED="1615652013151" ID="7vkiodcsing44i35cv6gdt8os9" MODIFIED="1615652013151" TEXT="(stock|stok) darah @Keyword"/>
        <node CREATED="1615652013151" ID="785bfhrthbk1oao0svnt0h2ok7" MODIFIED="1615652013151" TEXT="pstk @Keyword"/>
      </node>
    </node>
    <node CREATED="1615652013151" ID="3gql8802j8uobnqhh6lg5pej5k" MODIFIED="1615652013151" POSITION="right" TEXT="🗓️ Jadwal MU">
      <node BACKGROUND_COLOR="#F2F2F2" CREATED="1615652013151" ID="6cbhrjbdunml1b5e0g521mbhq4" MODIFIED="1615652013151" TEXT="{ecosystem_baseurl}/services/health/pmijateng/schedule/">
        <font NAME="SansSerif" SIZE="10"/>
      </node>
      <node CREATED="1615652013151" ID="04ev85hbhp66sf5l0memt7cmse" MODIFIED="1615652013151" TEXT="pattern">
        <node CREATED="1615652013151" ID="2av2n7evqutk45t0ob3vqut8sb" MODIFIED="1615652013151" TEXT="jadwal mu (di|kota) @Keyword"/>
        <node CREATED="1615652013151" ID="4u2d2scgp1b4q8gbqfr660e9q9" MODIFIED="1615652013151" TEXT="jadwal mu @Keyword"/>
        <node CREATED="1615652013151" ID="3mnh78tjevfa1od57sol7becsd" MODIFIED="1615652013151" TEXT="jadwal mu"/>
        <node CREATED="1615652013151" ID="02ia8uhc8tnvjont4kvqdsdgjm" MODIFIED="1615652013151" TEXT="pjwd @Keyword"/>
      </node>
    </node>
    <node CREATED="1615652013151" ID="7h8l02b0plihd7pjm99i6jr2ig" MODIFIED="1615652013151" POSITION="left" TEXT="📞 Kontak">
      <node BACKGROUND_COLOR="#F2F2F2" CREATED="1615652013151" ID="28d0iaqle8rk1mr9vjprpl5aa6" MODIFIED="1615652013151" TEXT="{ecosystem_baseurl}/services/health/pmijateng/address/">
        <font NAME="SansSerif" SIZE="10"/>
      </node>
      <node CREATED="1615652013151" ID="3ht0jfh2hhm8edg9gob4d32e9k" MODIFIED="1615652013151" TEXT="pattern">
        <node CREATED="1615652013151" ID="5hkrbstjk4knmabqbarb9a1aaq" MODIFIED="1615652013151" TEXT="alamat (udd|pmi) (di|kota) @Keyword"/>
        <node CREATED="1615652013151" ID="32mr4qb95455aj8m3smv922n47" MODIFIED="1615652013151" TEXT="alamat (udd|pmi) @Keyword"/>
        <node CREATED="1615652013151" ID="52qjh7ongpgsg81rpp2lp9fcce" MODIFIED="1615652013151" TEXT="alamat (udd|pmi)"/>
        <node CREATED="1615652013151" ID="28tfvuio75gp4hgjdfc7q55j0a" MODIFIED="1615652013151" TEXT="padd @Keyword"/>
      </node>
    </node>
  </node>
</map>

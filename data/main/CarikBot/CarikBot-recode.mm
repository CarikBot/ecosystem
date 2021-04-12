<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<map version="0.8.1">
  <node CREATED="1618217416459" ID="b9aa22deba98b3b20c7ac8aca2" MODIFIED="1618217416459" STYLE="bubble" TEXT="CarikBot">
    <hook NAME="accessories/plugins/NodeNote.properties">
      <text>
                Hi, Selamat %time_session%

Sementara ini saya baru bisa merespon pertanyaan Anda secara sederhana,
secara umum saya baru bisa: info hari dan jam, jadwal sholat, berhitung, arti kata, cari lokasi

contoh ucapannya sepert ini
```
#&gt; bot, sekarang jam berapa?
#&gt; jadwal sholat
#&gt; coba hitung 1*1
#&gt; artinya kehidupan
#&gt; cari lokasi (atm,hotel,restoran,terminal,klinik,busway,dll)
#&gt; hotel di jalan sudirman jakarta
#&gt; arah ke monas jakarta
#&gt; info gempa
#&gt; stok darah
```

Carik saat ini baru tersedia di:
- Telegram, t.me/carikbot
- Facebook, m.me/Carik.Bot
- FB Page, fb.me/Carik.Bot
- Line, line.me/ti/p/~@carik
- Instagram, instagram.com/carikbot/
- Android App, carik.id/app

Oiyaa... 
Selain dengan percakapan, kamu juga bisa memilih menu di bawah ini.
.
            </text>
    </hook>
    <node CREATED="1618217416460" ID="193b56735e689ae86a01d91513" MODIFIED="1618217416460" POSITION="right" TEXT="🌦 Cuaca">
      <node BACKGROUND_COLOR="#F2F2F2" CREATED="1618217416460" ID="61lrimrpaj3e6ejcmn8shl9n9u" MODIFIED="1618217416460" TEXT="Cuaca memang lagi tidak menentu. Hujan hampir tiap hari, panaspun seperti mantan yang dinanti. Cari informasi cuaca di kotamu di sini.">
        <font NAME="SansSerif" SIZE="10"/>
      </node>
      <node CREATED="1618217416460" ID="34v7r318aenr666fpq01cugfnf" MODIFIED="1618217416460" TEXT="Action Type">
        <node CREATED="1618217416460" ID="4ie4bu0071d822mts7q7l176ss" MODIFIED="1618217416460" TEXT="button"/>
      </node>
      <node CREATED="1618217416460" ID="35gt00dgj7bmqb86f0gbkn5i4v" MODIFIED="1618217416460" TEXT="Action">
        <node CREATED="1618217416460" ID="87ce8e4d-5528-4c4f-a50c-08dd4c674514" MODIFIED="1618217416460" TEXT="🌦 Cuaca">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:cuaca di jakarta
                        </text>
          </hook>
        </node>
        <node CREATED="1618217416460" ID="df9193fb-a813-43a4-b674-aa9cae3304dd" MODIFIED="1618217416460" TEXT="🌋 BMKG">
          <node BACKGROUND_COLOR="#F2F2F2" CREATED="1618217416460" ID="1bn1adtvorf7ghr4ofc2uhsocb" MODIFIED="1618217416460" TEXT="Informasi prakiraan cuaca, gempabumi dan tsunami bisa dari sini.&#10;Tapi pastikan kroscek dengan BMKG yaa..">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
          <node CREATED="1618217416460" ID="6ndkb2hef5n1jg762sue9g9uur" MODIFIED="1618217416460" TEXT="Action Type">
            <node CREATED="1618217416460" ID="43cdf0vc5o3nbeqh71o01va0hv" MODIFIED="1618217416460" TEXT="button"/>
          </node>
          <node CREATED="1618217416460" ID="70gcgn90dg29tm288poadt676e" MODIFIED="1618217416460" TEXT="Action">
            <node CREATED="1618217416460" ID="3c62d87b-0358-4aca-bb61-0b5134761596" MODIFIED="1618217416460" TEXT="🏜 Gempa">
              <hook NAME="accessories/plugins/NodeNote.properties">
                <text>
                                    callback:info gempa
                                </text>
              </hook>
            </node>
            <node CREATED="1618217416460" ID="2320950e-368e-4d20-b563-d1a909460f99" MODIFIED="1618217416460" TEXT="🌋 Volcano">
              <hook NAME="accessories/plugins/NodeNote.properties">
                <text>
                                    callback:info volcano
                                </text>
              </hook>
            </node>
            <node CREATED="1618217416460" ID="3a08e24f-fc2a-4eb0-b739-5db114a03bab" MODIFIED="1618217416460" TEXT="🌊 Tsunami">
              <hook NAME="accessories/plugins/NodeNote.properties">
                <text>
                                    callback:info tsunami
                                </text>
              </hook>
            </node>
            <node CREATED="1618217416460" ID="fd70c183-a459-4b49-9ceb-0142ea1f1d9a" MODIFIED="1618217416460" TEXT="🌧 Peta Hujan">
              <hook NAME="accessories/plugins/NodeNote.properties">
                <text>
                                    callback:peta hujan
                                </text>
              </hook>
            </node>
          </node>
          <node CREATED="1618217416460" ID="1ckv9uubon9ct08jpgvape17bt" MODIFIED="1618217416460" TEXT="pattern">
            <node CREATED="1618217416460" ID="4lum62fov0t4m0veg8k6g9g6rt" MODIFIED="1618217416460" TEXT="info bmkg"/>
          </node>
        </node>
        <node CREATED="1618217416460" ID="1393c297-39e0-4bb9-aa74-026ea7ed35db" MODIFIED="1618217416460" TEXT="🚤 Laut">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:info bakamla
                        </text>
          </hook>
        </node>
        <node CREATED="1618217416460" ID="d6a99b95-2d38-483a-b2d2-d377f5427ac1" MODIFIED="1618217416460" TEXT="👮‍♀️ Nomor Darurat">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:nomor darurat
                        </text>
          </hook>
        </node>
        <node CREATED="1618217416460" ID="3c0hshobn4tef9ehdhsvfjblsk" MODIFIED="1618217416460" TEXT="🦠 Covid-19">
          <node BACKGROUND_COLOR="#F2F2F2" CREATED="1618217416460" ID="6f61lekgatujtiai77qivhjrgr" MODIFIED="1618217416460" TEXT="http://public-nlp.carik.id/services/health/covid/?compact=1&amp;province=">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
        </node>
      </node>
    </node>
    <node CREATED="1618217416460" ID="624a5ab8-e8c1-4d73-bd22-d59ba7a75861" MODIFIED="1618217416460" POSITION="right" TEXT="Religi">
      <node BACKGROUND_COLOR="#F2F2F2" CREATED="1618217416460" ID="55k5a46vmbk928ppfo4vhhn2pr" MODIFIED="1618217416460" TEXT="Kuatkan iman, kuatkan hati. Semoga dengan informasi ini akan lebih meningkatkan kualitas hati kita.">
        <font NAME="SansSerif" SIZE="10"/>
      </node>
      <node CREATED="1618217416460" ID="24au3hr7l8ki421gfj2frn3tpa" MODIFIED="1618217416460" TEXT="Action Type">
        <node CREATED="1618217416461" ID="2inqavij1o2685mrdtgo1enp9o" MODIFIED="1618217416461" TEXT="button"/>
      </node>
      <node CREATED="1618217416461" ID="6pu8umqakbllnkpja1eqsc7oju" MODIFIED="1618217416461" TEXT="Action">
        <node CREATED="1618217416461" ID="305041a7-7d8e-426a-be1c-09607c127429" MODIFIED="1618217416461" TEXT="🕐 Jadwal Sholat">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:jadwal sholat
                        </text>
          </hook>
        </node>
        <node CREATED="1618217416461" ID="a81542f1-3776-4ade-9319-debcf4ced4a8" MODIFIED="1618217416461" TEXT="Ayat Al Quran">
          <node BACKGROUND_COLOR="#F2F2F2" CREATED="1618217416461" ID="3rj6cbod55029hbnsq80cmjl5d" MODIFIED="1618217416461" TEXT="Mendapatkan informasi tentang ayat-ayat Al Quran akan lebih mudah di sini. Coba ketikkan seperti ini:&#10;`surat al fatihah ayat 1`">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
        </node>
        <node CREATED="1618217416461" ID="0009fa6f-f568-44c3-ad8a-26f250c73c97" MODIFIED="1618217416461" TEXT="🤲 Doa Harian">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:doa harian
                        </text>
          </hook>
        </node>
        <node CREATED="1618217416461" ID="40i7no7u6idbg28jvsfsj4hjuc" MODIFIED="1618217416461" TEXT="🕌 Masjid terdekat">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:masjid terdekat
                        </text>
          </hook>
        </node>
      </node>
      <node CREATED="1618217416461" ID="4q7vbole2698m8turrvao8ctcq" MODIFIED="1618217416461" TEXT="pattern">
        <node CREATED="1618217416461" ID="0tgnb1vhg8jie6in3ht2qbq6eg" MODIFIED="1618217416461" TEXT="info (agama|religi)"/>
      </node>
    </node>
    <node CREATED="1618217416461" ID="67ddbcb1-85c9-4478-a0aa-580e9fdcd971" MODIFIED="1618217416461" POSITION="right" TEXT="⏱ Life Style">
      <node CREATED="1618217416461" ID="1m6eo1b0qeurhkrr3m8mf4ggan" MODIFIED="1618217416461" TEXT="Makin menyenangkan hidup kalau bisa dengan mudah mendapatkan informasi-informasi ini."/>
      <node CREATED="1618217416461" ID="3h3pahsoii3kjh849hmvr8eda4" MODIFIED="1618217416461" TEXT="Action Type">
        <node CREATED="1618217416461" ID="4pupnjt4r327jjglcobtajr6jf" MODIFIED="1618217416461" TEXT="button"/>
      </node>
      <node CREATED="1618217416461" ID="1kfrkkcm7huleh93s1ane92dik" MODIFIED="1618217416461" TEXT="Action">
        <node BACKGROUND_COLOR="#2CD551" CREATED="1618217416461" ID="da246fb2-6aa3-4464-a587-fd73067bf808" MODIFIED="1618217416461" TEXT="🔍 Global Search">
          <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416461" ID="ecb04dce-40dc-42ab-8a2e-3232d309e8f3" MODIFIED="1618217416461" TEXT="Anda bisa menggunakan layanan pencarian umum, caranya ketik&#10;`CARI INFO TENTANG ......`">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
        </node>
        <node CREATED="1618217416461" ID="b1d822ea-9393-45e2-8a4d-3147056b5e53" MODIFIED="1618217416461" TEXT="🥙 Kuliner">
          <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416461" ID="2mrvacttnpnel2l3k7uu0ubged" MODIFIED="1618217416461" TEXT="Mau cari tempat makan? Coba ketik&#10;`restoran di sudirman jakarta`&#10;&#10;atau, kalau mencari resep masakan, coba ketikkan:&#10;`RESEP MASAKAN ....`">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
        </node>
        <node CREATED="1618217416461" ID="0e7c648c-2f4a-4812-a63a-1d432a51be60" MODIFIED="1618217416461" TEXT="🧩 Cari Lokasi">
          <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416461" ID="7j5iudqi0bsd1uq50lr212rjfc" MODIFIED="1618217416461" TEXT="Cari-cari lokasi untuk hangout jadi nikmat, atau mungkin sedang darurat mau cari klinik?">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
          <node CREATED="1618217416461" ID="2copt7u5vbm7g0gigsb9250c2p" MODIFIED="1618217416461" TEXT="Action">
            <node CREATED="1618217416461" ID="7f42f887-e8ee-4514-97a7-16a0e3373099" MODIFIED="1618217416461" TEXT="🍽 Rumah Makan">
              <hook NAME="accessories/plugins/NodeNote.properties">
                <text>
                                    callback:rumah makan terdekat
                                </text>
              </hook>
            </node>
            <node CREATED="1618217416461" ID="6845307b-ba9f-4a33-9a42-8f9219b9536c" MODIFIED="1618217416461" TEXT="⛽️ SPBU">
              <hook NAME="accessories/plugins/NodeNote.properties">
                <text>
                                    callback:spbu terdekat
                                </text>
              </hook>
            </node>
            <node CREATED="1618217416461" ID="4fdcb2b5-f500-4148-ae19-fb5704dfeb61" MODIFIED="1618217416461" TEXT="🏧 ATM">
              <hook NAME="accessories/plugins/NodeNote.properties">
                <text>
                                    callback:atm terdekat
                                </text>
              </hook>
            </node>
            <node CREATED="1618217416461" ID="1nlijnbh8lva7q283cc6qpg9da" MODIFIED="1618217416461" TEXT="🧳 Hotel">
              <hook NAME="accessories/plugins/NodeNote.properties">
                <text>
                                    callback:hotel terdekat
                                </text>
              </hook>
            </node>
            <node CREATED="1618217416461" ID="23ol4fq5fi7s159kqi666n29iv" MODIFIED="1618217416461" TEXT="🏥 Rumah Sakit/Klinik">
              <hook NAME="accessories/plugins/NodeNote.properties">
                <text>
                                    callback:rumah sakit terdekat
                                </text>
              </hook>
            </node>
          </node>
        </node>
        <node CREATED="1618217416461" ID="b087edb4-f6ab-4b0c-8a32-721cf5de8146" MODIFIED="1618217416461" TEXT="🌾 Sembako">
          <node BACKGROUND_COLOR="#F2F2F2" CREATED="1618217416461" ID="5rtfmdlgehl6hkc0pokb69qp1i" MODIFIED="1618217416461" TEXT="Anda bisa mendapatkan informasi tentang harga bahan pokok untuk wilayah Jawa Tengah, ketikkan:&#10;`HARGA BERAS`">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
        </node>
        <node CREATED="1618217416461" ID="e5b95d3e-f448-44d4-bae6-6013f0641fd7" MODIFIED="1618217416461" TEXT="📘 Kamus KBBI">
          <node BACKGROUND_COLOR="#F2F2F2" CREATED="1618217416461" ID="29jikhg97bbj5kp3qcnkj53tv2" MODIFIED="1618217416461" TEXT="Berbagai informasi tentang arti kata bisa kamu dapatkan di sini, ketikkan (misal):&#10;`ARTINYA KEMERDEKAAN`">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
        </node>
        <node CREATED="1618217416461" ID="20aaa44c-08f2-4297-ae13-aff21034a98a" MODIFIED="1618217416461" TEXT="🚖 Lalu Lintas">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:info lalu lintas
                        </text>
          </hook>
        </node>
      </node>
      <node CREATED="1618217416461" ID="23m45snsmllgs3pnmpnsvu5rf3" MODIFIED="1618217416461" TEXT="pattern">
        <node CREATED="1618217416461" ID="0uiauvd6s9ppmtkao7h4e3f1f3" MODIFIED="1618217416461" TEXT="info gaya hidup"/>
        <node CREATED="1618217416461" ID="6vt3fgv7ihg1b5b7vlaua3pg6n" MODIFIED="1618217416461" TEXT="info hidup"/>
        <node CREATED="1618217416461" ID="47k7vkgd51hvqvn5crc769oijo" MODIFIED="1618217416461" TEXT="^lifestyle"/>
      </node>
    </node>
    <node CREATED="1618217416461" ID="e7416d36-e4c5-4705-8966-c9122e1a3bab" MODIFIED="1618217416461" POSITION="right" TEXT="🏃‍♂️ Olahraga">
      <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416461" ID="37mn05coq9mbq2i6o5hg9og111" MODIFIED="1618217416461" TEXT="Sedang pandemi begini, memang aktivitas fisik untuk sementara dibatasi. Tapi beberapa informasi masih tersedia kok.">
        <font NAME="SansSerif" SIZE="10"/>
      </node>
      <node CREATED="1618217416461" ID="7iopvcaqe199an9l6qf3sb7mu5" MODIFIED="1618217416461" TEXT="Action Type">
        <node CREATED="1618217416461" ID="4u5lnab2ndinqbjb1m7iidrvn5" MODIFIED="1618217416461" TEXT="button"/>
      </node>
      <node CREATED="1618217416461" ID="65i7id8vfn27godkvvorirnrvn" MODIFIED="1618217416461" TEXT="Action">
        <node BACKGROUND_COLOR="none" CREATED="1618217416461" ID="4f33484c-fc72-41ee-b527-52e723f68f72" MODIFIED="1618217416461" TEXT="⚽️ Info Bola">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:info bola
                        </text>
          </hook>
        </node>
        <node CREATED="1618217416461" ID="1f9dac71-8fb8-4cf5-a2d9-e481353ed531" MODIFIED="1618217416461" TEXT="🏀 Info NBA">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:info nba
                        </text>
          </hook>
        </node>
      </node>
      <node CREATED="1618217416461" ID="03u388ojd0tq9grv53ce08o011" MODIFIED="1618217416461" TEXT="pattern">
        <node CREATED="1618217416461" ID="2vttpop9vc35mmbsqtgj8dsdnj" MODIFIED="1618217416461" TEXT="info (olahraga)(sport)"/>
      </node>
    </node>
    <node CREATED="1618217416461" ID="b58888b5ceebbf0e68dada0656" MODIFIED="1618217416461" POSITION="left" TEXT="💶 Finance">
      <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416461" ID="52b923blovh4lqk5j1fiiu646o" MODIFIED="1618217416461" TEXT="Aktivitas finansial nyaris tidak berhenti walau pandemi begini. Coba cari info-info ini.">
        <font NAME="SansSerif" SIZE="10"/>
      </node>
      <node CREATED="1618217416461" ID="1rq5t7gnn85rml4t99vab7bfff" MODIFIED="1618217416461" TEXT="Action Type">
        <node CREATED="1618217416461" ID="7dbc86vkku623uaeai44dv6cj5" MODIFIED="1618217416461" TEXT="button"/>
      </node>
      <node CREATED="1618217416461" ID="6qbbr6ab13le1bhkhma8ejgfvf" MODIFIED="1618217416461" TEXT="Action">
        <node CREATED="1618217416461" ID="c7a387d9-4e55-4a7a-84e4-255c58475f4c" MODIFIED="1618217416461" TEXT="💶 Kurs">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:kurs
                        </text>
          </hook>
        </node>
        <node CREATED="1618217416462" FOLDER="true" ID="e345942d-b0ac-4ce9-9e95-abd084907246" MODIFIED="1618217416462" TEXT="🟡 Bitcoin">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:kurs bitcoin
                        </text>
          </hook>
          <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416462" ID="2m4mnsl52al88ms2icmvbdqpcq" MODIFIED="1618217416462" TEXT="Kamu bisa cek kurs crypto di sini.&#10;Caranya, ketik dengan format penulisan:&#10;`kurs bitcoin [KodeBitcoin]`&#10;&#10;contoh:&#10;`kurs bitcoin btc`&#10;`kurs bitcoin eth`&#10;`kurs bitcoin doge`">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
        </node>
        <node CREATED="1618217416462" ID="a07ab4c7-0bfa-472e-9525-37c6319624f5" MODIFIED="1618217416462" TEXT="🥇 Emas">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:harga emas
                        </text>
          </hook>
        </node>
        <node CREATED="1618217416462" ID="83d5ae85-7e22-4082-8c48-7be246d8a849" MODIFIED="1618217416462" TEXT="Info Saham">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:cek saham
                        </text>
          </hook>
        </node>
        <node CREATED="1618217416462" FOLDER="true" ID="5rhphup4mu9nrhkvd91qvibcag" MODIFIED="1618217416462" TEXT="🌟 Donasi">
          <node CREATED="1618217416462" ID="60u7lqhdc7a2l7upiag5a1u6sq" MODIFIED="1618217416462" TEXT="Mau berdonasi ke @CarikBot? boleh kok.&#10;Pilih nominal di bawah ini, selanjutnya kami akan memberikan kode *QRIS* kepada Anda.&#10;Pembayaran bisa dilakukan melalui jasa pembayaran yang kamu sukai.&#10;&#10;Jika lebih suka transfer tunai, boleh ke rekening:&#10;*BCA*&#10;*4620.313.586*&#10;a.n. Luri Darmawan&#10;kalau sudah, Kabarin yaa?&#10;&#10;Terima kasih&#10;"/>
          <node CREATED="1618217416462" ID="3c8hqumlqhiiputehgb5i4ir41" MODIFIED="1618217416462" TEXT="Action Type">
            <node CREATED="1618217416462" ID="70kt1h0q09ap0l7hpigs474884" MODIFIED="1618217416462" TEXT="button"/>
          </node>
          <node CREATED="1618217416462" ID="16odcoj19vjfu271pfjbffe1ee" MODIFIED="1618217416462" TEXT="Action">
            <node CREATED="1618217416462" ID="7si1s4jp4m1ij2cl0gminms7ao" MODIFIED="1618217416462" TEXT="10rb">
              <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416462" ID="0oh99ns0nul4jk9c7v3lenfpf0" MODIFIED="1618217416462" TEXT="Anda memilih donasi sebesar Rp. 10.000.">
                <font NAME="SansSerif" SIZE="10"/>
              </node>
              <node CREATED="1618217416462" ID="5ugac5smsffgb4t44hl8ilc4u5" MODIFIED="1618217416462" TEXT="Action Type">
                <node CREATED="1618217416462" ID="1u416esmph5kpimuhc116ngn98" MODIFIED="1618217416462" TEXT="button"/>
              </node>
              <node CREATED="1618217416462" ID="0a318rreqrubq75ujfu2gggfug" MODIFIED="1618217416462" TEXT="Action">
                <node CREATED="1618217416462" ID="5o8i2vj5vhpeon4946rt9rqjmc" MODIFIED="1618217416462" TEXT="Yakin, donasi 10rb">
                  <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416462" ID="30po4ua0h53gutsnhn1ssmf6uv" MODIFIED="1618217416462" TEXT="{ecosystem_baseurl}/Commerce/cart/?cmd=add&amp;checkout=1&amp;number=1&amp;price=10001&amp;description=Donasi+10rb">
                    <font NAME="SansSerif" SIZE="10"/>
                  </node>
                </node>
                <node CREATED="1618217416462" ID="2m2gkiu2ggr1va8432tb20t1fm" MODIFIED="1618217416462" TEXT="Tidak">
                  <node CREATED="1618217416462" ID="6ki6s6g2n6nerkbiepgqs72ekq" MODIFIED="1618217416462" TEXT="Baik, terima kasih."/>
                </node>
              </node>
            </node>
            <node CREATED="1618217416462" ID="13hgl1uutj56p381oiej7hs13h" MODIFIED="1618217416462" TEXT="25rb">
              <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416462" ID="3p5g6kg73dulheqbqnvkitr320" MODIFIED="1618217416462" TEXT="Anda memilih donasi sebesar Rp. 25.000.">
                <font NAME="SansSerif" SIZE="10"/>
              </node>
              <node CREATED="1618217416462" ID="1nsalba7lgoetb3tq51oblal3e" MODIFIED="1618217416462" TEXT="Action Type">
                <node CREATED="1618217416462" ID="5i8u1ku8383bf8nftd8si5smut" MODIFIED="1618217416462" TEXT="button"/>
              </node>
              <node CREATED="1618217416462" ID="61ougbrj4cvmj5dmcraqcm0nj9" MODIFIED="1618217416462" TEXT="Action">
                <node CREATED="1618217416462" ID="1rj7ttqrk86vppd55kpoh607el" MODIFIED="1618217416462" TEXT="Yakin, Donasi 20rb">
                  <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416462" ID="603jgqfi0i5rahmo648jactibd" MODIFIED="1618217416462" TEXT="{ecosystem_baseurl}/Commerce/cart/?cmd=add&amp;checkout=1&amp;number=1&amp;price=20001&amp;description=Donasi+20rb">
                    <font NAME="SansSerif" SIZE="10"/>
                  </node>
                </node>
                <node CREATED="1618217416462" ID="66gj6sou4m7ugpgomrm97imets" MODIFIED="1618217416462" TEXT="Tidak">
                  <node CREATED="1618217416462" ID="3b87b6de8so0rgt9h0pe21vlo3" MODIFIED="1618217416462" TEXT="Baik, terima kasih."/>
                </node>
              </node>
            </node>
            <node CREATED="1618217416462" ID="3mqtg22g9n1j53dtvrkqlrd9vq" MODIFIED="1618217416462" TEXT="50rb">
              <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416462" ID="4qk6etmo3h5mknmmsip6ncgnng" MODIFIED="1618217416462" TEXT="Anda memilih donasi sebesar Rp. 50.000.">
                <font NAME="SansSerif" SIZE="10"/>
              </node>
              <node CREATED="1618217416462" ID="5b2qs3kcsongg4j9ksh2hp0g05" MODIFIED="1618217416462" TEXT="Action Type">
                <node CREATED="1618217416462" ID="70cpc161vc4qa95gvt3uu7rs6u" MODIFIED="1618217416462" TEXT="button"/>
              </node>
              <node CREATED="1618217416462" ID="0a05er1huecms0um5lsvvfch4g" MODIFIED="1618217416462" TEXT="Action">
                <node CREATED="1618217416462" ID="6erpv409qauuomjjujq288d91f" MODIFIED="1618217416462" TEXT="Yakin, Donasi 50rb">
                  <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416462" ID="627oublt01hucqs54scqgt4bhn" MODIFIED="1618217416462" TEXT="{ecosystem_baseurl}/Commerce/cart/?cmd=add&amp;checkout=1&amp;number=1&amp;price=50001&amp;description=Donasi+50rb">
                    <font NAME="SansSerif" SIZE="10"/>
                  </node>
                </node>
                <node CREATED="1618217416462" ID="3mbf2shrlk9ilkr09hhph05h62" MODIFIED="1618217416462" TEXT="Tidak">
                  <node CREATED="1618217416462" ID="6vul8kef1eq9gkg82dk39u45bt" MODIFIED="1618217416462" TEXT="Baik, terima kasih."/>
                </node>
              </node>
            </node>
            <node CREATED="1618217416462" ID="2j118qid49eu6kh10vhetcqlkh" MODIFIED="1618217416462" TEXT="100rb">
              <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416462" ID="5oqccpmomdh8n1ut4ji1jpin5q" MODIFIED="1618217416462" TEXT="Anda memilih donasi sebesar Rp. 100.000.">
                <font NAME="SansSerif" SIZE="10"/>
              </node>
              <node CREATED="1618217416462" ID="2af578dcmpdvbungvm95ojkl9v" MODIFIED="1618217416462" TEXT="Action Type">
                <node CREATED="1618217416462" ID="6avqk8lf31hn6hb0dlofcghtoc" MODIFIED="1618217416462" TEXT="button"/>
              </node>
              <node CREATED="1618217416462" ID="5hr6bapo15umv19rhmia64empo" MODIFIED="1618217416462" TEXT="Action">
                <node CREATED="1618217416462" ID="0lemcu0fj9s4p48fggov1idegc" MODIFIED="1618217416462" TEXT="Yakin, Donasi 100rb">
                  <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416462" ID="64199cn6kmrtbbnikdqb6a5au4" MODIFIED="1618217416462" TEXT="{ecosystem_baseurl}/Commerce/cart/?cmd=add&amp;checkout=1&amp;number=1&amp;price=100001&amp;description=Donasi+100rb">
                    <font NAME="SansSerif" SIZE="10"/>
                  </node>
                </node>
                <node CREATED="1618217416462" ID="2f6ufc2733ffp6vllij9755rav" MODIFIED="1618217416462" TEXT="Tidak">
                  <node CREATED="1618217416462" ID="2sj1u2891jtovuid9osgcmh1l4" MODIFIED="1618217416462" TEXT="Baik, terima kasih."/>
                </node>
              </node>
            </node>
            <node CREATED="1618217416462" ID="6q1ot5un874b3o1su75kseipab" MODIFIED="1618217416462" TEXT="200rb">
              <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416462" ID="41v4e5v8c53igm22p95073aklo" MODIFIED="1618217416462" TEXT="Anda memilih donasi sebesar Rp. 200.000.">
                <font NAME="SansSerif" SIZE="10"/>
              </node>
              <node CREATED="1618217416462" ID="24ii53npkh8fdot3dqpce4g3b6" MODIFIED="1618217416462" TEXT="Action Type">
                <node CREATED="1618217416462" ID="77mlrb0i3l644tfnr7k8m6vlm7" MODIFIED="1618217416462" TEXT="button"/>
              </node>
              <node CREATED="1618217416462" ID="4rki15148us42jf85kk0to4onq" MODIFIED="1618217416462" TEXT="Action">
                <node CREATED="1618217416462" ID="4ntrjbfdfo1de5vbv2ptsmi3ri" MODIFIED="1618217416462" TEXT="Yakin, Donasi 200rb">
                  <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416463" ID="2j6a6kie5dqup7uh0en5cktilk" MODIFIED="1618217416463" TEXT="{ecosystem_baseurl}/Commerce/cart/?cmd=add&amp;checkout=1&amp;number=1&amp;price=200001&amp;description=Donasi+200rb">
                    <font NAME="SansSerif" SIZE="10"/>
                  </node>
                </node>
                <node CREATED="1618217416463" ID="4pfrl7nbel8hvfm3eq4941e4j4" MODIFIED="1618217416463" TEXT="Tidak">
                  <node CREATED="1618217416463" ID="6gjog481hd4v3358pio8r4hred" MODIFIED="1618217416463" TEXT="Baik, terima kasih."/>
                </node>
              </node>
            </node>
            <node CREATED="1618217416463" ID="7lmkhjf390ua99k626cbq0tg7u" MODIFIED="1618217416463" TEXT="500rb">
              <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416463" ID="4mu2ed60ki4037g562dvn926h2" MODIFIED="1618217416463" TEXT="Anda memilih donasi sebesar Rp. 500.000.">
                <font NAME="SansSerif" SIZE="10"/>
              </node>
              <node CREATED="1618217416463" ID="33qk77sd6tp9mq38jehhmv9e78" MODIFIED="1618217416463" TEXT="Action Type">
                <node CREATED="1618217416463" ID="2u5fl5q53fitn8r99qtg956e2o" MODIFIED="1618217416463" TEXT="button"/>
              </node>
              <node CREATED="1618217416463" ID="77k4jum1jhkmj4u8u9b11ihed2" MODIFIED="1618217416463" TEXT="Action">
                <node CREATED="1618217416463" ID="645skngao0rdj7n51d1tlh794r" MODIFIED="1618217416463" TEXT="Yakin, Donasi 500rb">
                  <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416463" ID="0vidvbbk1glct48954v7bet4k6" MODIFIED="1618217416463" TEXT="{ecosystem_baseurl}/Commerce/cart/?cmd=add&amp;checkout=1&amp;number=1&amp;price=500001&amp;description=Donasi+500rb">
                    <font NAME="SansSerif" SIZE="10"/>
                  </node>
                </node>
                <node CREATED="1618217416463" ID="2cq1m1uc890o7qada57d4posn2" MODIFIED="1618217416463" TEXT="Tidak">
                  <node CREATED="1618217416463" ID="6c2ranm2av2torq7ndto1uff7o" MODIFIED="1618217416463" TEXT="Baik, terima kasih."/>
                </node>
              </node>
            </node>
          </node>
          <node CREATED="1618217416463" ID="22g5oqmad3lj8ltvsvg932pk0l" MODIFIED="1618217416463" TEXT="pattern">
            <node CREATED="1618217416463" ID="57cd2mk76b6on8oipjonu2ssdg" MODIFIED="1618217416463" TEXT="dnsi"/>
          </node>
        </node>
        <node CREATED="1618217416463" ID="04o19n1jtmvlks92go9s3gf6ak" MODIFIED="1618217416463" TEXT="🏠 Kembali"/>
      </node>
      <node CREATED="1618217416463" ID="3tlq8398fqh5t98u3e1k9at9qh" MODIFIED="1618217416463" TEXT="pattern">
        <node CREATED="1618217416463" ID="7qpcokvslki1hebhsluki13qdr" MODIFIED="1618217416463" TEXT="info (keuangan|finansial|finance)"/>
      </node>
    </node>
    <node CREATED="1618217416463" ID="c0437f96-7328-4b47-8618-31261ee24de4" MODIFIED="1618217416463" POSITION="left" TEXT="☺️ Kesehatan">
      <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416463" ID="22fn09e8dtdi0hn33tjr7mm2da" MODIFIED="1618217416463" TEXT="Saat kesehatan menjadi fokus utama. Semoga kamu tetap sehat dan selalu bisa berkumpul dengan keluarga yaa...&#10;Semangat !">
        <font NAME="SansSerif" SIZE="10"/>
      </node>
      <node CREATED="1618217416463" ID="495rl208cn9q3hi8h8s6kvhela" MODIFIED="1618217416463" TEXT="Action Type">
        <node CREATED="1618217416463" ID="1aoudui20h1mcin1tugr9hslmi" MODIFIED="1618217416463" TEXT="button"/>
      </node>
      <node CREATED="1618217416463" ID="39v2mnb2ao825llbt16fcft0mc" MODIFIED="1618217416463" TEXT="Action">
        <node CREATED="1618217416463" ID="072282b7-09d8-4efd-9c74-2d8a746dc08f" MODIFIED="1618217416463" TEXT="🦠 Covid">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:update covid
                        </text>
          </hook>
        </node>
        <node CREATED="1618217416463" ID="17avdqtnfbemqphl2djo3fb66t" MODIFIED="1618217416463" TEXT="💉 Vaksin">
          <node BACKGROUND_COLOR="#EEEEEE" CREATED="1618217416463" ID="2uubetemlp1diro8lk7cefmbmo" MODIFIED="1618217416463" TEXT="{ecosystem_baseurl}/services/health/covid19/vaksin-info/">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
          <node CREATED="1618217416463" ID="2et7k4vploc37608ld6ohu3cul" MODIFIED="1618217416463" TEXT="pattern">
            <node CREATED="1618217416463" ID="7n7h667gadi1skp78hbjhn5eei" MODIFIED="1618217416463" TEXT="info vaksin"/>
          </node>
        </node>
        <node CREATED="1618217416463" ID="d3b85b3a-27e3-4c5f-8853-0e9d9ef93687" MODIFIED="1618217416463" TEXT="👩‍🔬 Jadwal Dokter">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:jadwal dokter
                        </text>
          </hook>
        </node>
        <node CREATED="1618217416463" ID="b729fff1-cbe6-4900-8afc-c1b2a25b5387" MODIFIED="1618217416463" TEXT="🩸 Donor Darah">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:stok darah
                        </text>
          </hook>
        </node>
        <node BACKGROUND_COLOR="none" CREATED="1618217416463" ID="78b29ba8-165e-4dff-b529-8b1663cefcaa" MODIFIED="1618217416463" TEXT="Jadwal Donor Darah">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:jadwal donor darah
                        </text>
          </hook>
        </node>
        <node CREATED="1618217416463" ID="8cf2cb98-2fe0-44f8-bf86-b440b7a1ddaa" MODIFIED="1618217416463" TEXT="🚨 Nomor Darurat">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:nomor darurat
                        </text>
          </hook>
        </node>
      </node>
      <node CREATED="1618217416463" ID="0fena3fkr2grvm5pb0mob2i8pp" MODIFIED="1618217416463" TEXT="pattern">
        <node CREATED="1618217416463" ID="640o396am4sbb05r19v7qdnjuo" MODIFIED="1618217416463" TEXT="info (sehat|kesehatan)"/>
      </node>
    </node>
  </node>
</map>

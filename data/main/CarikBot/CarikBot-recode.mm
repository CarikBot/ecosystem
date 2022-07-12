<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<map version="0.8.1">
  <node ID="b9aa22deba98b3b20c7ac8aca2" STYLE="bubble" TEXT="CarikBot">
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
    <node ID="193b56735e689ae86a01d91513" POSITION="right" TEXT="🌦 Cuaca">
      <node BACKGROUND_COLOR="#F2F2F2" FOLDER="true" ID="61lrimrpaj3e6ejcmn8shl9n9u" TEXT="Cuaca memang lagi tidak menentu. Hujan hampir tiap hari, panaspun seperti mantan yang dinanti. Cari informasi cuaca di kotamu di sini.">
        <font NAME="SansSerif" SIZE="10"/>
      </node>
      <node FOLDER="true" ID="34v7r318aenr666fpq01cugfnf" TEXT="Action Type">
        <node FOLDER="true" ID="4ie4bu0071d822mts7q7l176ss" TEXT="button"/>
      </node>
      <node ID="35gt00dgj7bmqb86f0gbkn5i4v" TEXT="Action">
        <node FOLDER="true" ID="87ce8e4d-5528-4c4f-a50c-08dd4c674514" TEXT="🌦 Cuaca">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:cuaca di jakarta
                        </text>
          </hook>
        </node>
        <node ID="df9193fb-a813-43a4-b674-aa9cae3304dd" TEXT="🌋 BMKG">
          <node BACKGROUND_COLOR="#F2F2F2" FOLDER="true" ID="1bn1adtvorf7ghr4ofc2uhsocb" TEXT="Informasi prakiraan cuaca, gempabumi dan tsunami bisa dari sini.&#10;Tapi pastikan kroscek dengan BMKG yaa..">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
          <node FOLDER="true" ID="6ndkb2hef5n1jg762sue9g9uur" TEXT="Action Type">
            <node FOLDER="true" ID="43cdf0vc5o3nbeqh71o01va0hv" TEXT="button"/>
          </node>
          <node ID="70gcgn90dg29tm288poadt676e" TEXT="Action">
            <node FOLDER="true" ID="3c62d87b-0358-4aca-bb61-0b5134761596" TEXT="🏜 Gempa">
              <hook NAME="accessories/plugins/NodeNote.properties">
                <text>
                                    callback:info gempa
                                </text>
              </hook>
            </node>
            <node FOLDER="true" ID="2320950e-368e-4d20-b563-d1a909460f99" TEXT="🌋 Volcano">
              <hook NAME="accessories/plugins/NodeNote.properties">
                <text>
                                    callback:info volcano
                                </text>
              </hook>
            </node>
            <node FOLDER="true" ID="3a08e24f-fc2a-4eb0-b739-5db114a03bab" TEXT="🌊 Tsunami">
              <hook NAME="accessories/plugins/NodeNote.properties">
                <text>
                                    callback:info tsunami
                                </text>
              </hook>
            </node>
            <node FOLDER="true" ID="fd70c183-a459-4b49-9ceb-0142ea1f1d9a" TEXT="🌧 Peta Hujan">
              <hook NAME="accessories/plugins/NodeNote.properties">
                <text>
                                    callback:peta hujan
                                </text>
              </hook>
            </node>
          </node>
          <node FOLDER="true" ID="1ckv9uubon9ct08jpgvape17bt" TEXT="pattern">
            <node FOLDER="true" ID="4lum62fov0t4m0veg8k6g9g6rt" TEXT="info bmkg"/>
          </node>
        </node>
        <node FOLDER="true" ID="1393c297-39e0-4bb9-aa74-026ea7ed35db" TEXT="🚤 Laut">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:info bakamla
                        </text>
          </hook>
        </node>
        <node FOLDER="true" ID="d6a99b95-2d38-483a-b2d2-d377f5427ac1" TEXT="👮‍♀️ Nomor Darurat">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:nomor darurat
                        </text>
          </hook>
        </node>
        <node ID="3c0hshobn4tef9ehdhsvfjblsk" TEXT="🦠 Covid-19">
          <node BACKGROUND_COLOR="#F2F2F2" FOLDER="true" ID="6f61lekgatujtiai77qivhjrgr" TEXT="http://public-nlp.carik.id/services/health/covid/?compact=1&amp;province=">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
        </node>
      </node>
    </node>
    <node FOLDER="true" ID="624a5ab8-e8c1-4d73-bd22-d59ba7a75861" POSITION="right" TEXT="Religi">
      <node BACKGROUND_COLOR="#F2F2F2" FOLDER="true" ID="55k5a46vmbk928ppfo4vhhn2pr" TEXT="Kuatkan iman, kuatkan hati. Semoga dengan informasi ini akan lebih meningkatkan kualitas hati kita.">
        <font NAME="SansSerif" SIZE="10"/>
      </node>
      <node FOLDER="true" ID="24au3hr7l8ki421gfj2frn3tpa" TEXT="Action Type">
        <node FOLDER="true" ID="2inqavij1o2685mrdtgo1enp9o" TEXT="button"/>
      </node>
      <node FOLDER="true" ID="6pu8umqakbllnkpja1eqsc7oju" TEXT="Action">
        <node FOLDER="true" ID="305041a7-7d8e-426a-be1c-09607c127429" TEXT="🕐 Jadwal Sholat">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:jadwal sholat
                        </text>
          </hook>
        </node>
        <node FOLDER="true" ID="a81542f1-3776-4ade-9319-debcf4ced4a8" TEXT="Ayat Al Quran">
          <node BACKGROUND_COLOR="#F2F2F2" FOLDER="true" ID="3rj6cbod55029hbnsq80cmjl5d" TEXT="Mendapatkan informasi tentang ayat-ayat Al Quran akan lebih mudah di sini. Coba ketikkan seperti ini:&#10;`surat al fatihah ayat 1`">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
        </node>
        <node FOLDER="true" ID="0009fa6f-f568-44c3-ad8a-26f250c73c97" TEXT="🤲 Doa Harian">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:doa harian
                        </text>
          </hook>
        </node>
        <node FOLDER="true" ID="40i7no7u6idbg28jvsfsj4hjuc" TEXT="🕌 Masjid terdekat">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:masjid terdekat
                        </text>
          </hook>
        </node>
      </node>
      <node FOLDER="true" ID="4q7vbole2698m8turrvao8ctcq" TEXT="pattern">
        <node FOLDER="true" ID="0tgnb1vhg8jie6in3ht2qbq6eg" TEXT="info (agama|religi)"/>
      </node>
    </node>
    <node FOLDER="true" ID="67ddbcb1-85c9-4478-a0aa-580e9fdcd971" POSITION="right" TEXT="⏱ Life Style">
      <node FOLDER="true" ID="1m6eo1b0qeurhkrr3m8mf4ggan" TEXT="Makin menyenangkan hidup kalau bisa dengan mudah mendapatkan informasi-informasi ini."/>
      <node FOLDER="true" ID="3h3pahsoii3kjh849hmvr8eda4" TEXT="Action Type">
        <node FOLDER="true" ID="4pupnjt4r327jjglcobtajr6jf" TEXT="button"/>
      </node>
      <node FOLDER="true" ID="1kfrkkcm7huleh93s1ane92dik" TEXT="Action">
        <node BACKGROUND_COLOR="#2CD551" FOLDER="true" ID="da246fb2-6aa3-4464-a587-fd73067bf808" TEXT="🔍 Global Search">
          <node BACKGROUND_COLOR="#EEEEEE" FOLDER="true" ID="ecb04dce-40dc-42ab-8a2e-3232d309e8f3" TEXT="Anda bisa menggunakan layanan pencarian umum, caranya ketik&#10;`CARI INFO TENTANG ......`">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
        </node>
        <node FOLDER="true" ID="b1d822ea-9393-45e2-8a4d-3147056b5e53" TEXT="🥙 Kuliner">
          <node BACKGROUND_COLOR="#EEEEEE" FOLDER="true" ID="2mrvacttnpnel2l3k7uu0ubged" TEXT="Mau cari tempat makan? Coba ketik&#10;`restoran di sudirman jakarta`&#10;&#10;atau, kalau mencari resep masakan, coba ketikkan:&#10;`RESEP MASAKAN ....`">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
        </node>
        <node FOLDER="true" ID="0e7c648c-2f4a-4812-a63a-1d432a51be60" TEXT="🧩 Cari Lokasi">
          <node BACKGROUND_COLOR="#EEEEEE" FOLDER="true" ID="7j5iudqi0bsd1uq50lr212rjfc" TEXT="Cari-cari lokasi untuk hangout jadi nikmat, atau mungkin sedang darurat mau cari klinik?">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
          <node FOLDER="true" ID="2copt7u5vbm7g0gigsb9250c2p" TEXT="Action">
            <node FOLDER="true" ID="7f42f887-e8ee-4514-97a7-16a0e3373099" TEXT="🍽 Rumah Makan">
              <hook NAME="accessories/plugins/NodeNote.properties">
                <text>
                                    callback:rumah makan terdekat
                                </text>
              </hook>
            </node>
            <node FOLDER="true" ID="6845307b-ba9f-4a33-9a42-8f9219b9536c" TEXT="⛽️ SPBU">
              <hook NAME="accessories/plugins/NodeNote.properties">
                <text>
                                    callback:spbu terdekat
                                </text>
              </hook>
            </node>
            <node FOLDER="true" ID="4fdcb2b5-f500-4148-ae19-fb5704dfeb61" TEXT="🏧 ATM">
              <hook NAME="accessories/plugins/NodeNote.properties">
                <text>
                                    callback:atm terdekat
                                </text>
              </hook>
            </node>
            <node FOLDER="true" ID="1nlijnbh8lva7q283cc6qpg9da" TEXT="🧳 Hotel">
              <hook NAME="accessories/plugins/NodeNote.properties">
                <text>
                                    callback:hotel terdekat
                                </text>
              </hook>
            </node>
            <node FOLDER="true" ID="23ol4fq5fi7s159kqi666n29iv" TEXT="🏥 Rumah Sakit/Klinik">
              <hook NAME="accessories/plugins/NodeNote.properties">
                <text>
                                    callback:rumah sakit terdekat
                                </text>
              </hook>
            </node>
          </node>
        </node>
        <node FOLDER="true" ID="b087edb4-f6ab-4b0c-8a32-721cf5de8146" TEXT="🌾 Sembako">
          <node BACKGROUND_COLOR="#F2F2F2" FOLDER="true" ID="5rtfmdlgehl6hkc0pokb69qp1i" TEXT="Anda bisa mendapatkan informasi tentang harga bahan pokok untuk wilayah Jawa Tengah, ketikkan:&#10;`HARGA BERAS`">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
        </node>
        <node FOLDER="true" ID="e5b95d3e-f448-44d4-bae6-6013f0641fd7" TEXT="📘 Kamus KBBI">
          <node BACKGROUND_COLOR="#F2F2F2" FOLDER="true" ID="29jikhg97bbj5kp3qcnkj53tv2" TEXT="Berbagai informasi tentang arti kata bisa kamu dapatkan di sini, ketikkan (misal):&#10;`ARTINYA KEMERDEKAAN`">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
        </node>
        <node FOLDER="true" ID="20aaa44c-08f2-4297-ae13-aff21034a98a" TEXT="🚖 Lalu Lintas">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:info lalu lintas
                        </text>
          </hook>
        </node>
      </node>
      <node FOLDER="true" ID="23m45snsmllgs3pnmpnsvu5rf3" TEXT="pattern">
        <node FOLDER="true" ID="0uiauvd6s9ppmtkao7h4e3f1f3" TEXT="info gaya hidup"/>
        <node FOLDER="true" ID="6vt3fgv7ihg1b5b7vlaua3pg6n" TEXT="info hidup"/>
        <node FOLDER="true" ID="47k7vkgd51hvqvn5crc769oijo" TEXT="^lifestyle"/>
      </node>
    </node>
    <node FOLDER="true" ID="e7416d36-e4c5-4705-8966-c9122e1a3bab" POSITION="right" TEXT="🏃‍♂️ Olahraga">
      <node BACKGROUND_COLOR="#EEEEEE" FOLDER="true" ID="37mn05coq9mbq2i6o5hg9og111" TEXT="Sedang pandemi begini, memang aktivitas fisik untuk sementara dibatasi. Tapi beberapa informasi masih tersedia kok.">
        <font NAME="SansSerif" SIZE="10"/>
      </node>
      <node FOLDER="true" ID="7iopvcaqe199an9l6qf3sb7mu5" TEXT="Action Type">
        <node FOLDER="true" ID="4u5lnab2ndinqbjb1m7iidrvn5" TEXT="button"/>
      </node>
      <node FOLDER="true" ID="65i7id8vfn27godkvvorirnrvn" TEXT="Action">
        <node BACKGROUND_COLOR="none" FOLDER="true" ID="4f33484c-fc72-41ee-b527-52e723f68f72" TEXT="⚽️ Info Bola">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:info bola
                        </text>
          </hook>
        </node>
        <node FOLDER="true" ID="1f9dac71-8fb8-4cf5-a2d9-e481353ed531" TEXT="🏀 Info NBA">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:info nba
                        </text>
          </hook>
        </node>
      </node>
      <node FOLDER="true" ID="03u388ojd0tq9grv53ce08o011" TEXT="pattern">
        <node FOLDER="true" ID="2vttpop9vc35mmbsqtgj8dsdnj" TEXT="info (olahraga)(sport)"/>
      </node>
    </node>
    <node ID="b58888b5ceebbf0e68dada0656" POSITION="left" TEXT="💶 Finance">
      <node BACKGROUND_COLOR="#EEEEEE" FOLDER="true" ID="52b923blovh4lqk5j1fiiu646o" TEXT="Aktivitas finansial nyaris tidak berhenti walau pandemi begini. Coba cari info-info ini.">
        <font NAME="SansSerif" SIZE="10"/>
      </node>
      <node FOLDER="true" ID="1rq5t7gnn85rml4t99vab7bfff" TEXT="Action Type">
        <node FOLDER="true" ID="7dbc86vkku623uaeai44dv6cj5" TEXT="button"/>
      </node>
      <node ID="6qbbr6ab13le1bhkhma8ejgfvf" TEXT="Action">
        <node FOLDER="true" ID="c7a387d9-4e55-4a7a-84e4-255c58475f4c" TEXT="💶 Kurs">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:kurs
                        </text>
          </hook>
        </node>
        <node FOLDER="true" ID="e345942d-b0ac-4ce9-9e95-abd084907246" TEXT="🟡 Bitcoin">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:kurs bitcoin
                        </text>
          </hook>
          <node BACKGROUND_COLOR="#EEEEEE" FOLDER="true" ID="2m4mnsl52al88ms2icmvbdqpcq" TEXT="Kamu bisa cek kurs crypto di sini.&#10;Caranya, ketik dengan format penulisan:&#10;`kurs bitcoin [KodeBitcoin]`&#10;&#10;contoh:&#10;`kurs bitcoin btc`&#10;`kurs bitcoin eth`&#10;`kurs bitcoin doge`">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
        </node>
        <node FOLDER="true" ID="a07ab4c7-0bfa-472e-9525-37c6319624f5" TEXT="🥇 Emas">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:harga emas
                        </text>
          </hook>
        </node>
        <node FOLDER="true" ID="83d5ae85-7e22-4082-8c48-7be246d8a849" TEXT="Info Saham">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:cek saham
                        </text>
          </hook>
        </node>
        <node ID="5rhphup4mu9nrhkvd91qvibcag" TEXT="🌟 Donasi">
          <node FOLDER="true" ID="60u7lqhdc7a2l7upiag5a1u6sq" TEXT="Mau berdonasi ke @CarikBot?&#10;Boleh kok.&#10;Pilih nominal di bawah ini, selanjutnya kami akan memberikan kode *QRIS* kepada Anda.&#10;Pembayaran bisa dilakukan melalui jasa pembayaran yang kamu sukai.&#10;&#10;Terima kasih yaa&#10;"/>
          <node FOLDER="true" ID="3c8hqumlqhiiputehgb5i4ir41" TEXT="Action Type">
            <node FOLDER="true" ID="70kt1h0q09ap0l7hpigs474884" TEXT="button"/>
          </node>
          <node ID="16odcoj19vjfu271pfjbffe1ee" TEXT="Action">
            <node ID="7si1s4jp4m1ij2cl0gminms7ao" TEXT="10rb">
              <node BACKGROUND_COLOR="#EEEEEE" FOLDER="true" ID="0oh99ns0nul4jk9c7v3lenfpf0" TEXT="Anda memilih donasi sebesar *Rp. 10.000*.&#10;Pembayaran bisa dilakukan melalui scan *QRIS* atau *eWallet* (LinkAja,Ovo,GoPay) kesayangan Anda.">
                <font NAME="SansSerif" SIZE="10"/>
              </node>
              <node FOLDER="true" ID="5ugac5smsffgb4t44hl8ilc4u5" TEXT="Action Type">
                <node FOLDER="true" ID="1u416esmph5kpimuhc116ngn98" TEXT="button"/>
              </node>
              <node ID="0a318rreqrubq75ujfu2gggfug" TEXT="Action">
                <node FOLDER="true" ID="57d86af0u77klc8mtf433slf3l" TEXT="eWallet">
                  <node BACKGROUND_COLOR="#EEEEEE" FOLDER="true" ID="0klqqbr2b1qbjbbv0grddcq5us" TEXT="{ecosystem_baseurl}/Commerce/cart/?cmd=add&amp;checkout=1&amp;gateway=2&amp;number=1&amp;price=10000&amp;random=0&amp;description=Donasi+10rb">
                    <font NAME="SansSerif" SIZE="10"/>
                  </node>
                </node>
                <node FOLDER="true" ID="2m2gkiu2ggr1va8432tb20t1fm" TEXT="Batal">
                  <node FOLDER="true" ID="6ki6s6g2n6nerkbiepgqs72ekq" TEXT="Baik, terima kasih."/>
                </node>
              </node>
            </node>
            <node ID="13hgl1uutj56p381oiej7hs13h" TEXT="25rb">
              <node BACKGROUND_COLOR="#EEEEEE" FOLDER="true" ID="3p5g6kg73dulheqbqnvkitr320" TEXT="Anda memilih donasi sebesar *Rp. 25.000*.&#10;Pembayaran bisa dilakukan melalui scan *QRIS* atau *eWallet* (LinkAja,Ovo,GoPay) kesayangan Anda.">
                <font NAME="SansSerif" SIZE="10"/>
              </node>
              <node FOLDER="true" ID="1nsalba7lgoetb3tq51oblal3e" TEXT="Action Type">
                <node FOLDER="true" ID="5i8u1ku8383bf8nftd8si5smut" TEXT="button"/>
              </node>
              <node ID="61ougbrj4cvmj5dmcraqcm0nj9" TEXT="Action">
                <node FOLDER="true" ID="2qmq9j2t67dedt0253sel3tnhb" TEXT="eWallet">
                  <node BACKGROUND_COLOR="#EEEEEE" FOLDER="true" ID="7vn986nrhaisltgqcgklrdfsce" TEXT="{ecosystem_baseurl}/Commerce/cart/?cmd=add&amp;checkout=1&amp;gateway=2&amp;number=1&amp;price=25000&amp;random=0&amp;description=Donasi+25rb">
                    <font NAME="SansSerif" SIZE="10"/>
                  </node>
                </node>
                <node FOLDER="true" ID="66gj6sou4m7ugpgomrm97imets" TEXT="Batal">
                  <node FOLDER="true" ID="3b87b6de8so0rgt9h0pe21vlo3" TEXT="Baik, terima kasih."/>
                </node>
              </node>
            </node>
            <node ID="7m50s01k9qqslfb0jd58mrsnf3" TEXT="Isi nominal sendiri">
              <node BACKGROUND_COLOR="#EEEEEE" FOLDER="true" ID="4ipb283fbmojp3nsb3tv3mtt7c" TEXT="{ecosystem_baseurl}/services/main/CarikBot/donasi/">
                <font NAME="SansSerif" SIZE="10"/>
              </node>
            </node>
          </node>
          <node ID="22g5oqmad3lj8ltvsvg932pk0l" TEXT="pattern">
            <node FOLDER="true" ID="6tlc2vf5onnl8tj0n2mb60usvq" TEXT="^donasi"/>
            <node ID="1bi6a33ll4dcst97eqgkbuck5q" TEXT="(mau|pengen|pengin|info) donasi"/>
          </node>
        </node>
        <node FOLDER="true" ID="04o19n1jtmvlks92go9s3gf6ak" TEXT="🏠 Kembali"/>
      </node>
      <node ID="3tlq8398fqh5t98u3e1k9at9qh" TEXT="pattern">
        <node FOLDER="true" ID="7qpcokvslki1hebhsluki13qdr" TEXT="info (keuangan|finansial|finance)"/>
      </node>
    </node>
    <node FOLDER="true" ID="c0437f96-7328-4b47-8618-31261ee24de4" POSITION="left" TEXT="☺️ Kesehatan">
      <node BACKGROUND_COLOR="#EEEEEE" FOLDER="true" ID="22fn09e8dtdi0hn33tjr7mm2da" TEXT="Saat kesehatan menjadi fokus utama. Semoga kamu tetap sehat dan selalu bisa berkumpul dengan keluarga yaa...&#10;Semangat !">
        <font NAME="SansSerif" SIZE="10"/>
      </node>
      <node FOLDER="true" ID="495rl208cn9q3hi8h8s6kvhela" TEXT="Action Type">
        <node FOLDER="true" ID="1aoudui20h1mcin1tugr9hslmi" TEXT="button"/>
      </node>
      <node FOLDER="true" ID="39v2mnb2ao825llbt16fcft0mc" TEXT="Action">
        <node FOLDER="true" ID="072282b7-09d8-4efd-9c74-2d8a746dc08f" TEXT="🦠 Covid">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:update covid
                        </text>
          </hook>
        </node>
        <node FOLDER="true" ID="17avdqtnfbemqphl2djo3fb66t" TEXT="💉 Vaksin">
          <node BACKGROUND_COLOR="#EEEEEE" FOLDER="true" ID="2uubetemlp1diro8lk7cefmbmo" TEXT="{ecosystem_baseurl}/services/health/covid19/vaksin-info/">
            <font NAME="SansSerif" SIZE="10"/>
          </node>
          <node FOLDER="true" ID="2et7k4vploc37608ld6ohu3cul" TEXT="pattern">
            <node FOLDER="true" ID="7n7h667gadi1skp78hbjhn5eei" TEXT="info vaksin"/>
          </node>
        </node>
        <node FOLDER="true" ID="d3b85b3a-27e3-4c5f-8853-0e9d9ef93687" TEXT="👩‍🔬 Jadwal Dokter">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:jadwal dokter
                        </text>
          </hook>
        </node>
        <node FOLDER="true" ID="b729fff1-cbe6-4900-8afc-c1b2a25b5387" TEXT="🩸 Donor Darah">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:stok darah
                        </text>
          </hook>
        </node>
        <node BACKGROUND_COLOR="none" FOLDER="true" ID="78b29ba8-165e-4dff-b529-8b1663cefcaa" TEXT="Jadwal Donor Darah">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:jadwal donor darah
                        </text>
          </hook>
        </node>
        <node FOLDER="true" ID="8cf2cb98-2fe0-44f8-bf86-b440b7a1ddaa" TEXT="🚨 Nomor Darurat">
          <hook NAME="accessories/plugins/NodeNote.properties">
            <text>
                            callback:nomor darurat
                        </text>
          </hook>
        </node>
      </node>
      <node FOLDER="true" ID="0fena3fkr2grvm5pb0mob2i8pp" TEXT="pattern">
        <node FOLDER="true" ID="640o396am4sbb05r19v7qdnjuo" TEXT="info (sehat|kesehatan)"/>
      </node>
    </node>
  </node>
</map>

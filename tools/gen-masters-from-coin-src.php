#!/usr/bin/env php
<?php

define('EXCEPTION_CHAINPARAMS_NOTFOUND', 1001);

//globals;
$stop_on_validation_error = true;    // set to true to view exception details.
$skip_existing_files = true;        // set to false to overwrite existing files.

$symbol = @$argv[1];
$name = @$argv[2];
$project_url = @$argv[3];    // eg https://github.com/digibyte/digibyte

$coins = [
    'btc'   => ['Bitcoin', 'https://github.com/bitcoin/bitcoin', 'v0.8.1'],       // use branch/tag v0.8.1 for pre chainparams.cpp code.
    'dgb'   => ['Digibyte', 'https://github.com/digibyte/digibyte', 'master'],
    'vtc'   => ['Vertcoin', 'https://github.com/vertcoin-project/vertcoin-core', 'master'],
    'dash'  => ['Dash', 'https://github.com/dashpay/dash', 'master'],
    'bch'   => ['Bitcoin Cash', 'https://github.com/Bitcoin-ABC/bitcoin-abc', 'master'],
    'doge'  => ['Dogecoin', 'https://github.com/dogecoin/dogecoin', 'master'],
    'btg'   => ['Bitcoin Gold', 'https://github.com/BTCGPU/BTCGPU', 'master'],
    'ltc'   => ['Litecoin', 'https://github.com/litecoin-project/litecoin', 'master'],
    'qtum'  => ['Qtum', 'https://github.com/qtumproject/qtum', 'master'],
    'rdd'   => ['Reddcoin', 'https://github.com/reddcoin-project/reddcoin', 'master'],
    'zec'   => ['Zcash', 'https://github.com/zcash/zcash', 'master'],
    'blk'   => ['Blackcoin', 'https://github.com/CoinBlack/blackcoin', 'master'],
    'mona'  => ['Monacoin', 'https://github.com/monacoinproject/monacoin', 'master-0.15', 'master'],
    'nmc'   => ['Namecoin', 'https://github.com/namecoin/namecoin-core', 'master'],
    'bcd'   => ['Bitcoin Diamond', 'https://github.com/eveybcd/BitcoinDiamond', 'master'],
    'btcp'  => ['Bitcoin Private', 'https://github.com/BTCPrivate/BitcoinPrivate', 'master'],
    'kmd'   => ['Komodo', 'https://github.com/KomodoPlatform/komodo', 'master'],
    'xzc'   => ['ZCoin', 'https://github.com/zcoinofficial/zcoin', 'master'],
    'smart' => ['SmartCash', 'https://github.com/SmartCash/Core-Smart', '1.2.x'],
    'block' => ['Blocknet', 'https://github.com/BlocknetDX/BlockDX', 'master'],
    'zen'   => ['Zencash', 'https://github.com/ZencashOfficial/zen', 'master'],
    'pivx'  => ['PIVX', 'https://github.com/PIVX-Project/PIVX', 'master'],
    'game'  => ['GameCredits', 'https://github.com/gamecredits-project/GameCredits', 'master'],
    'grs'   => ['Groestlcoin', 'https://github.com/Groestlcoin/groestlcoin', 'master'],
    'zcl'   => ['ZClassic', 'https://github.com/z-classic/zclassic', 'master'],
    'bci'   => ['Bitcoin Interest', 'https://github.com/BitcoinInterestOfficial/BitcoinInterest', 'master'],   // bip44 not found.
    'xsn'   => ['Stakenet', 'https://github.com/X9Developers/XSN', 'master'],       // bip44 not found.
    'sxc'   => ['Sexcoin', 'https://github.com/sexcoin-project/sexcoin', 'master'], // bip44 not found
    'xpm'   => ['Primecoin', 'https://github.com/primecoin/primecoin', 'master'],  // no chainparams.cpp
    'lcc'   => ['Litecoin Cash', 'https://github.com/litecoincash-project/litecoincash', 'master'],
    'nav'   => ['Navcoin', 'https://github.com/NAVCoin/navcoin-core', 'master'],
    'btx'   => ['Bitcore', 'https://github.com/LIMXTEC/BitCore', 'master'],
    'linda' => ['Linda', 'https://github.com/Lindacoin/Linda', 'master'],
    'emc2'  => ['Einsteinium', 'https://github.com/emc2foundation/einsteinium', 'master_EMC2_HardFork'],
    'uno'   => ['Unobtanium', 'https://github.com/unobtanium-official/Unobtanium', 'master'],
    'via'   => ['Viacoin', 'https://github.com/viacoin/viacoin', 'master'],
    'sls'   => ['SaluS', 'https://github.com/saluscoin/SaluS', 'master'],
    'bco'   => ['BridgeCoin', 'https://github.com/CryptoBridge/bridgecoin', 'master'],
    'rvn'   => ['Ravencoin', 'https://github.com/RavenProject/Ravencoin', 'master'],
    'gin'   => ['GINcoin', 'https://github.com/gincoin-dev/gincoin-core', 'master'],
    'ftc'   => ['Feathercoin', 'https://github.com/FeatherCoin/Feathercoin', 'master'],
    'ion'   => ['ION', 'https://github.com/ionomy/ion', 'master'],
    'flo'   => ['FlorinCoin', 'https://github.com/floblockchain/flo', 'flo-master'],
    'phr'   => ['Phore', 'https://github.com/phoreproject/Phore', 'master'],
    'html'  => ['HTMLCOIN', 'https://github.com/HTMLCOIN/HTMLCOIN', 'master'],
    'mnx'   => ['Minex', 'https://github.com/minexcoin/minexcoin', 'master'],
    'bitg'  => ['Bitcoin Green', 'https://github.com/bitcoingreen/bitcoingreen', 'master'],
    'pura'  => ['Pura', 'https://github.com/puracore/pura', 'master'],
    'xto'   => ['Tao', 'https://github.com/taoblockchain/tao-core', 'master'],
    'alqo'  => ['ALQO', 'https://github.com/alqocrypto/alqo', 'master'],
    'colx'  => ['ColossusXT', 'https://github.com/ColossusCoinXT/ColossusCoinXT', 'master'],
    'lux'   => ['LUXCoin', 'https://github.com/216k155/lux', 'master'],
    'crw'   => ['Crown', 'https://github.com/Crowndev/crown-core', 'master'],
    'dmd'   => ['Diamond', 'https://github.com/DMDcoin/Diamond', 'master'],
    'rads'  => ['Radium', 'https://github.com/RadiumCore/radium-0.11', 'master'],
    'moon'  => ['Mooncoin', 'https://github.com/mooncoincore/wallet', 'master'],
    'slr'   => ['SolarCoin', 'https://github.com/onsightit/solarcoin', 'master'],
    'dev'   => ['DeviantCoin', 'https://github.com/Deviantcoin/Source', 'master'],
    'rby'   => ['Rubycoin', 'https://github.com/rubycoinorg/rubycoin', 'master'],
    'clam'  => ['Clams', 'https://github.com/nochowderforyou/clams', 'master'],
    'xmy'   => ['Myriad', 'https://github.com/myriadteam/myriadcoin', 'master'],
    'bca'   => ['Bitcoin Atom', 'https://github.com/bitcoin-atom/bitcoin-atom', 'master'],
    'hxx'   => ['Hexx', 'https://github.com/hexxcointakeover/hexxcoin', 'master'],
    'sib'   => ['SIBCoin', 'https://github.com/ivansib/sibcoin', 'master'],
    'gam'   => ['Gambit', 'https://github.com/collincrypto/gambitcrypto', 'master'],  // no chainparams.cpp
    'bsd'   => ['BitSend', 'https://github.com/LIMXTEC/BitSend', 'master'],
    'bwk'   => ['Bulwark', 'https://github.com/bulwark-crypto/Bulwark', 'master'],
    'polis' => ['Polis', 'https://github.com/polispay/polis', 'master'],
    'au'    => ['AurumCoin', 'https://github.com/aurumcoin/Aurumcoin_AU', 'master'],  // no chainparams.cpp
    'gbx'   => ['GoByte', 'https://github.com/gobytecoin/gobyte', 'master'],
    'apr'   => ['APR Coin', 'https://github.com/APRCoin/zenith-repository', 'master'],
    'mlm'   => ['MktCoin', 'https://github.com/Mktcoin-official/Mktcoin', 'master'],
    'seq'   => ['Sequence', 'https://github.com/duality-solutions/Sequence', 'master'],
    'btcz'  => ['BitcoinZ', 'https://github.com/btcz/bitcoinz', 'master'],
    'zoi'   => ['Zoin', 'https://github.com/zoinofficial/zoin', 'master'],
    'sphr'  => ['Sphere', 'https://github.com/SphereDevs/sphere', 'master'],
    'fst'   => ['Fastcoin', 'https://github.com/fastcoinproject/fastcoin', 'master'],   // no chainparams.cpp
    'trc'   => ['Terracoin', 'https://github.com/terracoin/terracoin', 'master'],
    'aur'   => ['Auroracoin', 'https://github.com/aurarad/auroracoin', 'master'],
//    ''   => ['', '', 'master'],

    'ppc'   => ['Peercoin', 'https://github.com/peercoin/peercoin', 'master'],  // no chainparams.cpp
    'cnx'   => ['Kryptonex', 'https://github.com/Cryptonex/source', 'master'],  // no chainparams.cpp   
    'emc'   => ['Emercoin', 'https://github.com/emercoin/emercoin', 'master'],  // bip44 unset
    'btcd'  => ['BitcoinDark', 'https://github.com/jl777/btcd', 'master'],   // no chainparams.cpp
//    'nlg'   => ['Gulden', 'https://github.com/Gulden/gulden-official', 'master'],   // parse errors in chainparams.cpp
//    'tpay'  => ['TokenPay', 'https://github.com/tokenpay/tokenpay', 'master'],     // not working yet.  can't find where COIN is defined for per1.        
//    'part'  => ['Particle', 'https://github.com/particl/particl-core', 'master'],  // not working yet.  needs modified parsing of PUBLIC_KEY, et al.
//    'bay'   => ['BitBay', 'https://github.com/bitbaymarket/bitbay-core', 'master'],   // parse error in chainparams.cpp
    'fair'  => ['FairCoin', 'https://github.com/FairCoinTeam/fair-coin', 'master'],  // no chainparams.cpp
//    'cloak' => ['CloakCoin', 'https://github.com/CloakProject/CloakCoin', 'master'],  // no chainparams.cpp, no main.cpp
//    'xwc'   => ['WhiteCoin', 'https://github.com/Whitecoin-org/whitecoin', 'master'],  // parse error in chainparams.cpp
//    '$pac'  => ['PACcoin', 'https://github.com/PACCommunity/PAC', 'master'],   // parse error in chainparams.cpp
//    'lbc'   => ['Library Credits', 'https://github.com/lbryio/lbrycrd', 'master'],   // parse error in chainparams.cpp
    'xp'    => ['Experience Points', 'https://github.com/eXperiencePoints/XPCoin', 'master'],  // no chainparams.cpp
//    'medic' => ['MedicCoin', 'https://github.com/MEDICCOIN/MedicCoin', 'master'],  // parse error in chainparams.cpp
    'nlc2'  => ['NoLimiteCoin', 'https://github.com/NoLimitCoin/NoLimitCoin-Core', 'master'],   // no chainparams.cpp
//    'ecc'   => ['ECC', 'https://github.com/project-ecc/eccoin', 'master'],  // no chainparams.cpp, parse error for pchMessages
//    'xby'   => ['XTRABYTES', 'https://github.com/XTRABYTES/XTRABYTES', 'master'],  // no chainparams.cpp,  no bitcoinrpc.cpp
//    'pot'   => ['PotCoin', 'https://github.com/potcoin/Potcoin', 'master'],  // no chainparams.cpp,  no base58.cpp
//    'leo'   => ['LEOcoin', 'https://github.com/Leocoin-project/LEOcoin', 'master'],  // COIN not defined in amount.h or util.h
    'thx'   => ['HempCoin', 'https://github.com/hempcoin-project/THC', 'master'],  // no chainparams.cpp
    'onion' => ['DeepOnion', 'https://github.com/deeponion/deeponion', 'master'],  // no chainparams.cpp
//    'dime'  => ['Dimecoin', 'https://github.com/dime-coin/dimecoin', 'master'],  // no chainparams.cpp, no base58.cpp
//    'bitb'  => ['Bean Cash', 'https://github.com/TeamBitBean/bitbean-core', 'master'],   // parse error in chainparams.cpp
    'grc'   => ['Gridcoin', 'https://github.com/gridcoin-community/Gridcoin-Research', 'master'],  // no chainparams.cpp
//    'mue'   => ['MonetaryUnit', 'https://github.com/muecoin/MUECore', 'master'],   // parse error in chainparams.cpp
//    'flash' => ['FLASH', 'https://github.com/flash-coin/flash-fullnode', 'master'],   // parse error in chainparams.cpp
//    'shnd'  => ['StrongHands', 'https://github.com/stronghands/stronghands', 'master'],  // no chainparams.cpp, pchMessageStart not in main.cpp
//    'ioc'   => ['IO Coin', 'https://github.com/IOCoin/DIONS', 'master'],  // no chainparams.cpp,  no base58.cpp
//    'nyc'   => ['NewYorkCoin', 'https://github.com/NewYorkCoin-NYC/nycoin', 'master'],  // no chainparams.cpp, no base58.cpp
//    'lmc'   => ['LoMoCoin', 'https://github.com/lomocoin/lomocoin-qt', 'master'],  // no chainparams.cpp, parse error in main.cpp
    'hwc'   => ['Hollywood Coin', 'https://github.com/hollywoodcoin-project/HollyWoodCoin', 'master'],  // no chainparams
    'vrc'   => ['Vericoin', 'https://github.com/vericoin/vericoin', 'master'],  // no chainparams.cpp
//    'dyn'   => ['Dynamic', 'https://github.com/duality-solutions/Dynamic', 'master'],  // parse error in chainparams.cpp
    'nvc'   => ['Novacoin', 'https://github.com/novacoin-project/novacoin', 'master'],  // no chainparams
//    'esp'   => ['Espers', 'https://github.com/cryptocoderz/espers', 'master'],  // parse error in chainparams.cpp
//    'sprts' => ['Sprouts', 'https://github.com/sprouts-coin-org/sprouts', 'master'],  // no chainparams.cpp,  parse error in main.cpp
//    'xst'   => ['Stealth', 'https://github.com/StealthSend/Stealth', 'master'],  // no chainparams.cpp, error parsing hashGenesisBlock
    'bio'   => ['Biocoin', 'https://github.com/Blackithart/biocoin', 'master'],  // no chainparams.cpp
//    'ok'    => ['OKCash', 'https://github.com/okcashpro/okcash', 'master'],  // COIN not defined in amount.h, util.h
    'pink'  => ['PinkCoin', 'https://github.com/Pink2Dev/Pink2', 'master'],  // no chainparams.cpp
    'bcc'   => ['Bitconnect', 'https://github.com/bitconnectcoin/bitconnectcoin', 'master'],  // no chainparams.cpp. also, ponzi scammers
    'pnd'   => ['Pandacoin', 'https://github.com/DigitalPandacoin/pandacoin', 'master'],  // no chainparams.cpp
//    'xspec' => ['Spectrecoin', 'https://github.com/spectrecoin/spectre', 'master'],  // COIN not defined in amount.h, util.h
    'enrg'  => ['Energycoin', 'https://github.com/EnergyCoinProject/energycoin', 'master'],   // no chainparams.cpp
//    'cure'  => ['Curecoin', 'https://github.com/cygnusxi/CurecoinSource', 'master'],  // no chainparams.cpp, missing base58.cpp
//    'qrk'   => ['Quark', 'https://github.com/quark-project/quark', 'master'],   // parse error in chainparams.cpp (hashGenesisBlock difficult to parse, outside main section.)
    '42'    => ['42-Coin', 'https://github.com/42-coin/42', 'master'],  // no chainparams.cpp
//    'hold'  => ['Interstellar Holdings', 'https://github.com/InterstellarHoldings/StellarHoldings', 'master'],   // parser error messageMagic not found.
];


if( $symbol && $name && $project_url ) {
    process_coin($symbol, $name, $project_url);
}
else if( $symbol ) {
    $ci = @$coins[strtolower($symbol)];
    if( !$ci ) {
        throw new Exception( "Coin $symbol not found.");
    }
    list($name, $url, $branch) = $ci;
    process_coin($symbol, $name, $url, $branch);
}
else {
    foreach($coins as $symbol => $ci) {
        list($name, $url, $branch) = $ci;
        process_coin($symbol, $name, $url, $branch);
    }
}

function process_coin($symbol, $name, $project_url, $branch) {
    
    echo "\nProcessing $symbol - $name\n";

    $outfile = sprintf( "%s/../coins/%s.json", __DIR__, strtolower($symbol));
    if(file_exists($outfile)) {
        if($GLOBALS['skip_existing_files']) {
            warn("file " . basename($outfile) . " exists. skipping $name");
            return;
        }
    }    
    
    @list($prefix, $path) = explode('github.com/', $project_url);
    $urlbase = sprintf("https://raw.githubusercontent.com/%s/%s", $path, $branch);
    
    $data = [];
    $meta = ['symbol' => $symbol, 'name' => $name, 'urlbase' => $urlbase];
    
    $networks = ['main', 'test', 'regtest'];
    
    foreach($networks as $network) {
        try {
            $meta['network'] = $network;
            process_network($data, $meta);
        }
        catch(Exception $e) {
            if($GLOBALS['stop_on_validation_error']) {
                throw $e;
            }
            warn($e->getMessage() . "  --> $network will be ignored.");
            unset($data[$network]);
            continue;
        }
    }
    
    $json = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($outfile, $json);
    echo "  |- Wrote $outfile\n";
}

function process_network(&$data, $meta) {
    
    $network = $meta['network'];
    info("Processing network '$network'");

    try {    
        process_chainparams_codebase($data, $meta);
    }
    catch(Exception $e) {
        switch( $e->getCode() ) {
            case EXCEPTION_CHAINPARAMS_NOTFOUND:
                unset($data[$network]);
                // be silent about missing regtest because it is always missing for old codebases.
                if( $network == 'regtest' ) {
                    break;
                }
                if($network == 'main') {
                    // be silent about this for testnet, because already warned for mainnet.
                    warn("chainparams.cpp not found. Coin is old or wrong branch? will parse as old codebase.");
                }
                process_oldbitcoin_codebase($data, $meta);
                break;
            default:
                throw($e);
        }
    }    
}

function process_chainparams_codebase(&$data, $meta) {
    process_meta($data, $meta);
    process_chainparams($data, $meta);
    process_chainparamsbase($data, $meta);
    process_amounts($data, $meta);
    process_message_magic($data, $meta);
    process_bip44($data, $meta);
}

function process_chainparams(&$data, $meta) {
    $network = $meta['network'];

    // note: chainparams.cpp was introduced around bitcoin v0.9.0.
    // older altcoins (eg Peercoin) may not have it and would
    // require a different parsing implementation.
    $url =  $meta['urlbase'] . '/src/chainparams.cpp';
    $buf = get_url($url, false);
    
    if(!$buf) {
        throw new Exception("$url not found", EXCEPTION_CHAINPARAMS_NOTFOUND);
    }
    
    $main = $testnet = $regtest = null;
    $chunks = explode("Params : public", $buf);
    $buf = null;

    foreach($chunks as $chunk) {
        if(strstr($chunk, '   CMainParams()') && $network =='main') {
            $buf = $chunk;
        }
        else if(strstr($chunk, '   CTestNetParams()') && $network == 'test') {
            $buf = $chunk;
        }
        else if(strstr($chunk, '   CRegTestParams()') && $network == 'regtest') {
            $buf = $chunk;
        }
    }

    process_chainparam_network( $data, $buf, $meta);
}

function process_chainparam_network( &$data, $buf, $meta) {

    $network = $meta['network'];
    $name = $meta['name'];
    $symbol = $meta['symbol'];
        
    preg_match_all("/pchMessageStart\[.\] = (....)/", $buf, $matches) ||
    preg_match_all("/netMagic\[.\] = (....)/", $buf, $matches);  // bch just has to be special.  ;-)
    ne(@$matches[1][0]);
    $magic = '0x';
    foreach( array_reverse($matches[1]) as $val) {
        $magic .= str_replace('0x', '', $val);
    }
    
    preg_match("/nDefaultPort = (\d+)/", $buf, $matches);
    ne(@$matches[1]);
    $port = $matches[1];

    $data[$network]['protocol']['magic'] = $magic;
    $data[$network]['port'] = (int)$port;

    // rpcPort is usually in chainparamsbase.cpp, but sometimes
    // found in chainparams.cpp, eg blackcoin.
    preg_match("/nRPCPort = (\d+)/", $buf, $matches);
    if(@$matches[1]) {
        $data[$network]['portRpc'] = (int)$matches[1];
    }
    
    preg_match_all('/vSeeds.emplace_back\("(.*)".*\)/', $buf, $matches) ||
    preg_match_all('/PUSH_SEED\("(.*)"\)/', $buf, $matches) ||               // clams.
    preg_match_all('/vSeeds.push_back\(.*CDNSSeedData\("(.*)",.*"(.*)"[,\)]/sU', $buf, $matches);        
    
    $data[$network]['seedsDns'] = @$matches[1];  
    if( @$matches[2]) {
        $data[$network]['seedsDns'] = array_merge($matches[1], $matches[2]);
    }

    // must not be empty for network = main.
    if( !count($data[$network]['seedsDns']) && $network != 'regtest') {
        warn("'$network' - no DNS seeds found. seedsDns is empty.");
    }        

    preg_match("/base58Prefixes.SECRET_KEY.*>\s?\(1,\s?(\d+)\)/", $buf, $matches) ||
    preg_match("/base58Prefixes.SECRET_KEY.*list_of.(\d+)\)/", $buf, $matches) ||    // emercoin
    preg_match("/base58Prefixes.SECRET_KEY.*(0x..).;/", $buf, $matches);    // zcash is a special child.
    ne(@$matches[1]);
    array_shift($matches);
    $val = substr($matches[0],0,2) == '0x' ? hexdec(strtolower($matches[0])) : i($matches[0]);
    $data[$network]['versions']['private'] = $val;
    
    preg_match("/base58Prefixes.PUBKEY_ADDRESS.*>\s?\(1,\s?(\d+)\);/", $buf, $matches) ||
    preg_match("/base58Prefixes.PUBKEY_ADDRESS.*list_of.(\d+)\)/", $buf, $matches) ||    // emercoin
    preg_match("/base58Prefixes.PUBKEY_ADDRESS.*0x(..),0x(..).;/", $buf, $matches);    // zcash is a special child.
    ne(@$matches[1]);
    array_shift($matches);
    $val = count($matches) == 1 ? i($matches[0]) : hexdec(strtolower(implode('', $matches)));
    $data[$network]['versions']['public'] = $val;
    
    //if(!$matches[1]) echo $buf; exit;
    
    preg_match("/base58Prefixes.SCRIPT_ADDRESS.*>\s?\(1,\s?(\d+)\)/", $buf, $matches) ||
    preg_match("/base58Prefixes.SCRIPT_ADDRESS.*list_of\((\d+)\)/", $buf, $matches) ||    // emercoin
    preg_match("/base58Prefixes.SCRIPT_ADDRESS.*0x(..),0x(..).;/", $buf, $matches);    // zcash is a special child.
    ne(@$matches[1]);
    array_shift($matches);
    $val = count($matches) == 1 ? i($matches[0]) : hexdec(strtolower(implode('', $matches)));
    $data[$network]['versions']['scripthash'] = $val;
    
    preg_match("/base58Prefixes.EXT_PUBLIC_KEY.*\{0x(..),\s?0x(..),\s?0x(..),\s?0x(..)\}/", $buf, $matches) ||
    preg_match("/base58Prefixes.EXT_PUBLIC_KEY.*list_of.0x(..)..0x(..)..0x(..)..0x(..)/", $buf, $matches);
    ne(@$matches[1]);
    array_shift($matches);
    $data[$network]['versions']['bip32']['public'] = zpx(strtolower(implode('',($matches))));

    preg_match("/base58Prefixes.EXT_SECRET_KEY.*\{0x(..),\s?0x(..),\s?0x(..),\s?0x(..)\}/", $buf, $matches) ||
    preg_match("/base58Prefixes.EXT_SECRET_KEY.*list_of.0x(..)..0x(..)..0x(..)..0x(..)/", $buf, $matches);
    ne(@$matches[1]);
    array_shift($matches);
    $data[$network]['versions']['bip32']['private'] = zpx(strtolower(implode('',($matches))));

    preg_match('/bech32_hrp = "([^"]*)"/', $buf, $matches);
    // ne(@$matches[1]);  // can be null
    $data[$network]['versions']['bech32_hrp'] = @$matches[1];

//    preg_match('/{     0, uint256S\("([^"]*)"\)}/', $buf, $matches);
    preg_match('/assert\(.*hashGenesisBlock == uint256S?\("0?x?(.*)"\)\);/', $buf, $matches);
    if( !@$matches[1] ) {
        // special case for BCH.  (and others?)
        if(preg_match('/assert\(consensus.hashGenesisBlock ==.*uint256S\("(.*)".*"(.*)"\)\);/sU', $buf, $matches)) {
            array_shift($matches);
            $matches[1] = implode('', $matches);
        }
    }
    
    ne(@$matches[1]);
    $data[$network]['hashGenesisBlock'] = @$matches[1];
}

function process_chainparamsbase(&$data, $meta) {
    $network = $meta['network'];

    // if already found, we can stop.
    if(@$data[$network]['portRpc']) {
        return;
    }
    
    $url = $meta['urlbase'] . '/src/chainparamsbase.cpp';
    $buf = get_url($url);

    if($network == 'main') {
        preg_match('/MakeUnique<CBaseChainParams>\("", (\d+)\)/', $buf, $matches);
        $data['main']['portRpc'] = (int)@$matches[1];
    }
    else if($network == 'test') {
        preg_match('/MakeUnique<CBaseChainParams>\("testnet3", (\d+)\)/', $buf, $matches);
        $data['test']['portRpc'] = (int)@$matches[1];
    }
    else if($network == 'regtest') {
        preg_match('/MakeUnique<CBaseChainParams>\("regtest", (\d+)\)/', $buf, $matches);
        $data['regtest']['portRpc'] = (int)@$matches[1];
    }

    // if above fails, try older/legacy formatting.
    if( !@$matches[1] ) {
        preg_match_all('/nRPCPort = (\d+);/', $buf, $matches);
        if($network == 'main') {
            $data['main']['portRpc'] = (int)@$matches[1][0];
        }
        else if($network == 'test') {
            $data['test']['portRpc'] = (int)@$matches[1][1];
        }
        else if($network == 'regtest') {
            $data['regtest']['portRpc'] = (int)@$matches[1][2];
        }
    }
    
    return true;
}


function process_amounts(&$data, $meta) {
    $symbol = $meta['symbol'];
    $network = $meta['network'];

    $url = $meta['urlbase'] . '/src/amount.h';
    $buf = get_url($url, false);
    if(!$buf) {
        $url = $meta['urlbase'] . '/src/util.h';   // blackcoin has it in util.h.
        $buf = get_url($url);
    }

    preg_match('/static const .* COIN\s+=\s+(\d+);/', $buf, $matches) ||
    preg_match('/static const Amount COIN\((\d+)\);/', $buf, $matches);  // bch is different of course.
    $special = [       // special cases, hard to parse.
        'bcd' => 100000000 / 10,
        'lcc' => 100000000 / 10,  // https://github.com/litecoincash-project/litecoincash/blob/master/src/amount.h
        'clam' => 1000000 * 100, // https://raw.githubusercontent.com/nochowderforyou/clams/master/src/util.h
    ];
    if( @$special[$symbol] ) {
        $matches[1] = $special[$symbol];
    }
    
    ne(@$matches[1]);
    $data[$network]['per1'] = @$matches[1] ? (int)@$matches[1] : null;
    return true;
}

function process_message_magic(&$data, $meta) {
    $urlbase = $meta['urlbase'];
    $network = $meta['network'];

    $url = $urlbase . '/src/validation.cpp';
    $buf = get_url($url, false);
    if(!$buf || !strstr($buf, 'strMessageMagic')) {
        $url = $urlbase . '/src/main.cpp';
        $buf = get_url($url);
    }

    preg_match('/const .*string strMessageMagic = "(.*)";/', $buf, $matches);
    ne(@$matches[1]);
    
    $data[$network]['messageMagic'] = @$matches[1];    
    return true;
}


function process_bip44(&$data, $meta) {
    $symbol = $meta['symbol'];
    $network = $meta['network'];
    
    static $bip44map = null;
    if(!$bip44map) {
        $fixmap = ['DSH' => 'DASH',
                   ];
        
        $url = 'https://raw.githubusercontent.com/bitcoinjs/bip44-constants/master/index.js';
        $buf = get_url($url);
        
        $lines = explode("\n", $buf);
        array_shift($lines);
        array_pop($lines);
        $bip44map = [];
        foreach($lines as $line) {
            $line = str_replace('"', '', $line);
            list($sym, $hex) = explode(':', $line);
            $val = trim($hex, ", ");
            $val = str_replace('0x8', '0x', $val);
            $sym = trim($sym);
            $sym = @$fixmap[$sym] ?: $sym;
            $bip44map[$sym] = hexdec($val);
        }
    }
    $bip44 = @$bip44map[strtoupper($symbol)];
    if( $network == 'main' ) {
        $data['main']['versions']['bip44'] = $bip44;
    }
    else {
        $data[$network]['versions']['bip44'] = 1;     // testnets are always 1, per bip44 spec.
    }
}

function process_meta(&$data, $meta) {
    $name = $meta['name'];
    $network = $meta['network'];
    $symbol = $meta['symbol'];
    
    $netname = $network == 'test' ? 'testnet' : $network;
    $suffix = $network == 'main' ? '' : ' - ' . ucfirst($netname);
    $data[$network]['unit'] = strtoupper($symbol);
    $data[$network]['name'] = $name . $suffix;
    $data[$network]['testnet'] = $network == 'main' ? false : true;
}


function process_oldbitcoin_codebase(&$data, $meta) {
    if($meta['network'] == 'regtest') {
        // regtest network is not available in old bitcoin codebases.
        // so we fail silently.
        return;
    }
    
    process_meta($data, $meta);
    process_oldcode_protocol_magic($data, $meta);
    process_oldcode_ports($data, $meta);
    process_oldcode_dns_seeds($data, $meta);
    process_oldcode_keys($data, $meta);
    process_oldcode_hash_genesis_block($data, $meta);
    process_oldcode_per1($data, $meta);
    process_oldcode_message_magic($data, $meta);
    process_bip44($data, $meta);
}

function process_oldcode_hash_genesis_block(&$data, $meta) {
    $urlbase = $meta['urlbase'];
    $network = $meta['network'];
    
    $hash = null;

/** For orig bitcoin, looks like in main.cpp:
   uint256 hashGenesisBlock("0x000000000019d6689c085ae165831e934ff763ae46a2a6c172b3f1b60a8ce26f");
... later on, for testnet ...
    hashGenesisBlock = uint256("000000000933ea01ad0ee984209779baaec3ced90fa3f408719526f8d77f4943");
*/

    $url = $urlbase . '/src/main.cpp';
    $buf = get_url($url);
    
    if( $network == 'main') {
        preg_match('/uint256 hashGenesisBlock\("0x(.*)"\);/', $buf, $matches);
        $hash = @$matches[1];
    }
    else {
        preg_match('/hashGenesisBlock = uint256\("(.*)"\);/', $buf, $matches);
        $hash = @$matches[1];
    }    
    
    if($hash) {
        $data[$network]['hashGenesisBlock'] = $hash;
        return;
    }

    /** For peercoin, primecoin, looks like, in main.h:
    static const uint256 hashGenesisBlockOfficial("0x0000000032fe677166d54963b62a4677d8957e87c508eaa4fd7eb1c880cd27e3");
    static const uint256 hashGenesisBlockTestNet("0x00000001f757bb737f6596503e17cd17b0658ce630cc727c0cca81aec47c9f06");
     */
    
    $url = $urlbase . '/src/main.h';
    $buf = get_url($url);
    
    if( $network == 'main') {
        preg_match('/static const uint256 hashGenesisBlockOfficial\s?\("0?x?(.*)"\);/', $buf, $matches) ||
        preg_match('/static const uint256 hashGenesisBlock\s?(?!TestNet)\("0?x?(.*)"\);/', $buf, $matches);
        $hash = @$matches[1];
    }
    else {
        preg_match('/static const uint256 hashGenesisBlockTestNet\s?\("0?x?(.*)"\);/', $buf, $matches);
        $hash = @$matches[1];
    }
    
    ne($hash);
    $data[$network]['hashGenesisBlock'] = $hash;
}

function process_oldcode_ports(&$data, $meta) {
    $symbol = $meta['symbol'];
    $urlbase = $meta['urlbase'];
    $network = $meta['network'];

    // Shortcut for certain hard-to-parse codebases.    
    $known = [
        'cure' => [ 'main' => ['port' => 9911, 'rpc' => 19911],
                    'test' => ['port' => 8600, 'rpc' => 18600] ],
    ];
    if(@$known[$symbol]) {
        $data[$network]['port'] = $known[$symbol][$network]['port'];
        $data[$network]['portRpc'] = $known[$symbol][$network]['rpc'];
        return;
    }    
    
    $url = $urlbase . '/src/protocol.h';
    $buf = get_url($url);
    
/*  In ppc, xpm looks like
        #define PPCOIN_PORT  9901
        #define RPC_PORT     9902
        #define TESTNET_PORT 9903
        #define TESTNET_RPC_PORT 9904
 */

    if(strstr($buf, 'COIN_PORT') && strstr($buf, 'RPC_PORT')) {
        if( $network == 'main') {
            preg_match('/#define .*COIN_PORT \s*(\d+)/', $buf, $matches);
            ne(@$matches[1]);
            $data[$network]['port'] = i($matches[1]);
    
            preg_match('/#define .*RPC_PORT \s*(\d+)/', $buf, $matches);
            ne(@$matches[1]);
            $data[$network]['portRpc'] = i($matches[1]);
        }
        else {
            preg_match('/#define .*TESTNET_PORT \s*(\d+)/', $buf, $matches);
            ne(@$matches[1]);
            $data[$network]['port'] = i($matches[1]);
    
            preg_match('/#define .*TESTNET_RPC_PORT \s*(\d+)/', $buf, $matches);
            ne(@$matches[1]);
            $data[$network]['portRpc'] = i($matches[1]);
        }
    }

/** In btc, looks looks like
File: protocol.h
    return testnet ? 18333 : 8333;
File: bitcoinrpc.cpp
    return GetBoolArg("-testnet", false) ? 18332 : 8332;
 */
    else {
        preg_match('/return.*[tT]est[nN]et \? (\d+) : (\d+).?;/', $buf, $matches);
        ne(@$matches[1]);
        $data[$network]['port'] = $network == 'main' ? i($matches[2]) : i($matches[1]);
        
        $url = $urlbase . '/src/bitcoinrpc.cpp';
        $buf = get_url($url);

        preg_match('/return GetBoolArg.*testnet.*false.*\? (\d+) : (\d+);/', $buf, $matches);
        ne(@$matches[1]);
        $data[$network]['portRpc'] = $network == 'main' ? i($matches[2]) : i($matches[1]);
    }
}

function process_oldcode_protocol_magic(&$data, $meta) {
    $urlbase = $meta['urlbase'];
    $symbol = $meta['symbol'];
    $network = $meta['network'];
    
    // Shortcut for certain hard-to-parse codebases.    
    $known = [
        'ppc' => ['main' => '0xe5e9e8e6', 'test' => '0xefc0f2cb'],
    ];
    if(@$known[$symbol]) {
        $data[$network]['protocol']['magic'] = $known[$symbol][$network];
        return;
    }

    $url = $urlbase . '/src/main.cpp';
    $buf = get_url($url);
    
/*  In orig bitcoin looks like in main.cpp
unsigned char pchMessageStart[4] = { 0xf9, 0xbe, 0xb4, 0xd9 };
 ...  
    if (fTestNet)
    {
        pchMessageStart[0] = 0x0b;
        pchMessageStart[1] = 0x11;
        pchMessageStart[2] = 0x09;
        pchMessageStart[3] = 0x07;
        hashGenesisBlock = uint256("000000000933ea01ad0ee984209779baaec3ced90fa3f408719526f8d77f4943");
    }
 */
 
    if( $network == 'main') {
        preg_match('/unsigned char pchMessageStart\[4\] = { 0x(.*), 0x(.*), 0x(.*), 0x(.*) }/', $buf, $matches);
        ne(@$matches[1]);
        array_shift($matches);
        $data[$network]['protocol']['magic'] = zpx(implode(array_reverse($matches)));
    }
    else {
        preg_match_all('/pchMessageStart\[\d\] = 0x(.*);/', $buf, $matches);
        ne(@$matches[1]);
        $data[$network]['protocol']['magic'] = zpx(implode(array_reverse($matches[1])));
    }

}


function process_oldcode_per1(&$data, $meta) {
    $urlbase = $meta['urlbase'];
    $symbol = $meta['symbol'];
    $network = $meta['network'];
    
    // Shortcut for certain hard-to-parse codebases.    
    $known = [
//        'ppc' => 1000000,
    ];
    if(@$known[$symbol]) {
        $data[$network]['per1'] = $known[$symbol];
        return;
    }

    $url = $urlbase . '/src/util.h';
    $buf = get_url($url);
    
/*  In orig bitcoin looks like in util.h
static const int64 COIN = 100000000;
 */
 
    if(!preg_match('/static .* COIN = (\d+);/', $buf, $matches)) {
        $url = $urlbase . '/src/amount.h';
        $buf = get_url($url);
        preg_match('/static.* COIN = (\d+);/', $buf, $matches);
        ne(@$matches[1]);
    }
    $data[$network]['per1'] = i($matches[1]);
}


function process_oldcode_message_magic(&$data, $meta) {
    $urlbase = $meta['urlbase'];
    $symbol = $meta['symbol'];
    $network = $meta['network'];
    
    // Shortcut for certain hard-to-parse codebases.    
    $known = [
//        'myc' => "Mycoin signed message\n",
    ];
    if(@$known[$symbol]) {
        $data[$network]['per1'] = $known[$symbol];
        return;
    }

    $url = $urlbase . '/src/main.cpp';
    $buf = get_url($url);
    
    preg_match('/const .*string strMessageMagic = "(.*)";/', $buf, $matches);
    ne(@$matches[1]);

    $data[$network]['messageMagic'] = $matches[1];
}



function process_oldcode_dns_seeds(&$data, $meta) {
    $urlbase = $meta['urlbase'];
    $network = $meta['network'];

    $url = $urlbase . '/src/net.cpp';
    $buf = get_url($url);
    
    /** looks like:
static const char *strMainNetDNSSeed[][2] = {
    {"primecoin.net", "seed.ppcoin.net"},
    {"xpm.altcointech.net", "dnsseed.xpm.altcointech.net"},
    {"xpm2.altcointech.net", "dnsseed.xpm2.altcointech.net"},
    {"primeseed.muuttuja.org", "primeseed.muuttuja.org"},
    {NULL, NULL}
};

static const char *strTestNetDNSSeed[][2] = {
    {"primecoin.net", "tnseed.ppcoin.net"},
    {"primeseedtn.muuttuja.org", "primeseedtn.muuttuja.org"},
    {NULL, NULL}
};
     */
    
    $pattern = sprintf('/str%sNetDNSSeed.*{(.*){NULL,\s+NULL}/sU', ucfirst($network) );
    preg_match( $pattern, $buf, $matches);

    if( @$matches[1] ) {    
        preg_match_all('/{".*", "(.*)"},/', $matches[1], $matches);
        if(@count($matches[1])) {
            $data[$network]['seedsDns'] = $matches[1];
        }
    }
    
/**
 Another form looks like:
static const char *strDNSSeed[][2] = {
    {"seed1.gambit", "node1.gambitcrypto.com"},
    {"seed2.gambit", "node2.gambitcrypto.com"},
    {"seed3.gambit", "node3.gambitcrypto.com"}
};
from: https://raw.githubusercontent.com/collincrypto/gambitcrypto/master/src/net.cpp
*/  

    else {
        $pattern = '/strDNSSeed.*{(.*)};/sU';
        preg_match( $pattern, $buf, $matches);
    
        if( @$matches[1] ) {    
            preg_match_all('/{".*", "(.*)"}/', $matches[1], $matches);
            if(@count($matches[1]) && $network == 'main') {
                $data[$network]['seedsDns'] = $matches[1];
            }
        }
    }

    if( !@count($data[$network]['seedsDns']) ) {
        warn("'$network' - no DNS seeds found. seedsDns is empty.");
        $data[$network]['seedsDns'] = [];
    }
}

function process_oldcode_keys(&$data, $meta) {
    $urlbase = $meta['urlbase'];
    $network = $meta['network'];

    $url = $urlbase . '/src/base58.h';
    $buf = get_url($url);

/** Looks like
        PUBKEY_ADDRESS = 23,  // primecoin: pubkey address starts with 'A'
        SCRIPT_ADDRESS = 83,  // primecoin: script address starts with 'a'
        PUBKEY_ADDRESS_TEST = 111,
        SCRIPT_ADDRESS_TEST = 196,
*/        
    
    if( $network == 'main') {
        preg_match('/PUBKEY_ADDRESS = (\d+)/', $buf, $matches);
        ne(@$matches[1]);
        $data[$network]['versions']['public'] = i($matches[1]);
        
        preg_match('/SCRIPT_ADDRESS = (\d+)/', $buf, $matches);
        ne(@$matches[1]);
        $data[$network]['versions']['scripthash'] = i($matches[1]);
    }
    else {
        preg_match('/PUBKEY_ADDRESS_TEST = (\d+)/', $buf, $matches);
        ne(@$matches[1]);
        $data[$network]['versions']['public'] = i($matches[1]);
        
        preg_match('/SCRIPT_ADDRESS_TEST = (\d+)/', $buf, $matches);
        ne(@$matches[1]);
        $data[$network]['versions']['scripthash'] = i($matches[1]);
    }
    
    
/** SECRET_KEY.
 *  Looks like, in orig bitcoin.
            SetData(fTestNet ? 239 : 128, vchSecret.begin(), vchSecret.size());
 *  Looks like, in ppc, xpm
            SetData(128 + (fTestNet ? CBitcoinAddress::PUBKEY_ADDRESS_TEST : CBitcoinAddress::PUBKEY_ADDRESS), &vchSecret[0], vchSecret.size());
*/

    if( preg_match('/SetData\(fTestNet \? (\d+) : (\d+),/', $buf, $matches) ) {
        $val = $network == 'main' ? $matches[2] : $matches[1];
        $data[$network]['versions']['private'] = i($val);
    }
    else {
        if(preg_match('/SetData\((\d+) \+ \(fTestNet \? CBitcoinAddress::PUBKEY_ADDRESS_TEST : CBitcoinAddress::PUBKEY_ADDRESS\)/', $buf, $matches)) {
            $data[$network]['versions']['private'] = i( $matches[1] + $data[$network]['versions']['public'] );
        }
        else {
            // one last thing to try.
            // see: https://raw.githubusercontent.com/eXperiencePoints/XPCoin/master/src/base58.cpp
            if(!@$matches[1]) {
                $url = $urlbase . '/src/base58.cpp';
                $buf = get_url($url);
                
                preg_match('/SetData\((\d+) \+ \(fTestNet \? CBitcoinAddress::PUBKEY_ADDRESS_TEST : CBitcoinAddress::PUBKEY_ADDRESS\)/', $buf, $matches);
                ne(@$matches[1]);
                $data[$network]['versions']['private'] = i( $matches[1] + $data[$network]['versions']['public'] );
            }
        }
    }
    
    // Use bitcoin values for all coins using old codebase because
    // old codebase does not define bip32 extended key prefixes.
    // note: maybe there should be an option to turn this off,
    //       but then the values would be undefined and json files
    //       would not validate.
    $data[$network]['versions']['bip32']['public'] = '0x0488b21e';
    $data[$network]['versions']['bip32']['private'] = '0x0488ade4';
    $data[$network]['versions']['bech32_hrp'] = null;    
}


function get_url($url, $throw = true) {
    static $urlcache = [];
    if( isset($urlcache[$url]) ) {
        echo "  |- Cached: $url\n";
        return $urlcache[$url];
    }
    
    echo "  |- Loading $url\n";
    $buf = trim(@file_get_contents($url));
    
    if( !$buf && $throw ) {
        throw new Exception("Error loading $url");
    }
    
    $urlcache[$url] = $buf;
    return $buf;
}

function i($val) {
    return (int)$val;
}

function ihex($val) {
    return zpx(($val));
}

// zero pads a string to an even length of characters.
// intended for hex numbers.
function zp($val) {
    if(strlen($val) % 2 != 0) {
        $val = '0' . $val;
    }
    return $val;
}

function zpx($val) {
    return '0x' . zp($val);
}

function ne($val) {
    if( $val === null ) {
        throw new Exception("required value not found.");
    }
}

function err($msg) {
    fprintf(STDERR, "  |- Error : $msg\n" );
}

function warn($msg) {
    fprintf(STDERR, "  |- Warning : $msg\n" );
}

function info($msg) {
    fprintf(STDERR, "  |- Info : $msg\n" );
}

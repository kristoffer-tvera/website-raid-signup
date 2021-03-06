<?php session_start();
    include_once 'secrets.php';

    $state = htmlspecialchars($_GET['state']);
    $code = htmlspecialchars($_GET['code']);

    if(empty($state) && empty($code)){
        $session_state = bin2hex(random_bytes(8));
        $_SESSION["state"] = $session_state;
        $_SESSION["level"] = htmlspecialchars($_GET['level']);
        $_SESSION["faction"] = htmlspecialchars($_GET['faction']);
        header('Location: https://eu.battle.net/oauth/authorize?client_id=' . $client_id . '&scope=wow.profile&state=' . $session_state . '&redirect_uri=' . $redirect . '&response_type=code');
        exit;
    } else {
        $session_state = $_SESSION["state"];
        if($session_state != $state){
            $_SESSION["state"] = null;
            echo json_encode((object)array('error' => 'Invalid Session (cookie + state mismatch). Reload and try again.'));
            exit;
        }
    }

    $curl_token = curl_init( 'https://eu.battle.net/oauth/token' );

    $params = [
        'redirect_uri'=> $redirect,
        'scope'=>'wow.profile',
        'grant_type'=>'authorization_code',
        'code'=> $code
    ];
    curl_setopt( $curl_token, CURLOPT_POST, true);
    curl_setopt( $curl_token, CURLOPT_POSTFIELDS, $params);
    curl_setopt( $curl_token, CURLOPT_USERPWD, "$client_id:$client_secret");
    curl_setopt( $curl_token, CURLOPT_RETURNTRANSFER, true);
    curl_setopt( $curl_token, CURLOPT_HTTPHEADER, ['Content-Type: multipart/form-data']);

    $response = curl_exec( $curl_token );
    $status = curl_getinfo( $curl_token, CURLINFO_HTTP_CODE);
    curl_close( $curl_token );

    if ($status !== 200) {
        echo json_encode((object)array('error' => 'Failed to retrieved access token'));
        $_SESSION["state"] = null;
        echo json_encode((object)array('error' => 'Failed to create access token. Reload and try again.'));
        exit;
    }

    $decoded = json_decode($response);
    $access_token = $decoded->access_token;

    $url = 'https://eu.api.blizzard.com/profile/user/wow?namespace=profile-eu&locale=en_GB&access_token=' . $access_token;

    $curl_profile = curl_init( $url );
    curl_setopt( $curl_profile, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec( $curl_profile );
    $status = curl_getinfo( $curl_profile, CURLINFO_HTTP_CODE);

    curl_close( $curl_profile );

    if ($status !== 200) {
        echo json_encode((object)array('error' => 'Failed to fetch profile data'));
        throw new Exception('Failed to fetch profile data.');
    }

    $decoded = json_decode($response);

    $characters = [];
    $levelFilter = $_SESSION["level"];
    $factionFilter = $_SESSION["faction"];
    
    if(empty($levelFilter)){
        $levelFilter = 120;
    }else {
        $levelFilter = intval($levelFilter);
    }

    if(empty($factionFilter)){
        $factionFilter = 'Horde';
    }

    foreach($decoded->wow_accounts as $account){
        foreach($account->characters as $character){
            if($character->level == $levelFilter && $character->faction->name == $factionFilter){


                $sub_query = curl_init( $character->character->href . '&access_token=' . $access_token );
                curl_setopt( $sub_query, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec( $sub_query );
                $status = curl_getinfo( $sub_query, CURLINFO_HTTP_CODE);
                curl_close( $sub_query );

                $ilvl = 0;
                if ($status === 200) {
                    $decoded = json_decode($response);
                    $ilvl = intval($decoded->average_item_level);
                }

                $characters[] = (object)array(
                    'id' => $character->id,
                    'name' => $character->name, 
                    'server' => $character->realm->slug, 
                    'className' => $character->playable_class->id, 
                    'ilvl' => $ilvl, 
                    'tank' => false, 
                    'healer' => false, 
                    'dps' => false, 
                    'saved' => false, 
                );
            }
        }
    }
?>

<script>
    let charactersFromApi = <?php echo json_encode($characters) ?>;
    
    let characters = [];
    let fromLocalStorage = localStorage.getItem("characters");
    if (fromLocalStorage) {
        characters = JSON.parse(fromLocalStorage);
    }
    
    for (let i = 0; i < charactersFromApi.length; i++) {
        let alreadyInList = false;
        for (let j = 0; j < characters.length; j++) {
            if (characters[j].id == charactersFromApi[i].id) alreadyInList = true;
        }

        if (!alreadyInList) {
            characters.push(charactersFromApi[i]);
        }
    }

    localStorage.setItem("characters", JSON.stringify(characters));
    window.location.replace("https://signup.amusedtodeath.eu/");
</script>
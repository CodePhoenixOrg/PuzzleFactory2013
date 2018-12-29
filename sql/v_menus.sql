SELECT 
    me_id AS Menu,
    pa_id AS Page,
    me_level AS Niveau,
    di_name AS Dictionnaire,
    me_target AS Cible,
    pa_filename AS Fichier,
    di_fr_short AS 'Francais court',
    di_fr_long AS 'Francais long',
    di_en_short AS 'Anglais court',
    di_en_long AS 'Anglais long'
FROM
    v_menus
ORDER BY me_id

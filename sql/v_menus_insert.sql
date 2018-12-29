INSERT INTO v_menus
( 
    me_id,
    pa_id,
    me_level,
    di_name,
    me_target,
    pa_filename,
    di_fr_short,
    di_fr_long,
    di_en_short,
    di_en_long
) 
SELECT 
    m.me_id,
    m.pa_id,
    m.me_level,
    m.di_name,
    m.me_target,
    p.pa_filename,
    d.di_fr_short,
    d.di_fr_long,
    d.di_en_short,
    d.di_en_long
FROM
    menus m,
    pages p,
    dictionary d
WHERE
    m.di_name = d.di_name
        AND p.di_name = d.di_name
ORDER BY m.me_id

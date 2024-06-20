
Dans twig.yaml il a rajouté :
globals: img_upload_dir: '%app.upload_dir%'

Dans services.yaml il a rajouté : app.upload_dir: "/uploads/images/" dans les paramètres

et pour finir img_upload_dir dans la vue twig

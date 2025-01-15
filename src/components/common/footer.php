<?php
  // defino las url para el css del footer y el
  //$rutaFooter= $rutaFooter;
  $rutaImgs = BASE_URL.'assets/sitiosImg/';
?>

    <footer class="bg-dark text-light pt-3">
      <Section fluid class="w-100">
        <h2 class="text-center val-round">Sitios web de interés</h2>
        <section class="d-flex row align-items-center">
          <aside class="col-sm-12 col-md-6 col-lg-3 text-center">
            <a
              class=""
              href="http://estadistica.tucuman.gov.ar/"
              target="_blank"
              rel="noopener noreferrer"
            >
              <img
                class="img-interes"
                src = "<?php echo $rutaImgs?>defecto.png"
                alt="estadistica"
              />
            </a>
          </aside>

          <aside class="col-sm-12 col-md-6 col-lg-3 text-center mt-1">
            <a
              class=""
              href="http://planeamiento.tucuman.gob.ar/"
              target="_blank"
              rel="noopener noreferrer"
            >
              <img
                class="img-interes"
                src="<?php echo $rutaImgs?>defecto.png"
                alt="planeamiento"
              />
            </a>
          </aside>

          <aside class="col-sm-12 col-md-6 col-lg-3 text-center mt-1">
            <a
              class=""
              href="https://correorig.tucuman.gob.ar/"
              target="_blank"
              rel="noopener noreferrer"
            >
              <img
                class="img-interes"
                src="<?php echo $rutaImgs?>RIG.png"
                alt="rig"
              />
            </a>
          </aside>

          <aside class="col-sm-12 col-md-6 col-lg-3 text-center mt-1">
            <a
              class=""
              href="https://sep.tucuman.gob.ar/"
              target="_blank"
              rel="noopener noreferrer"
            >
              <img
                class="img-interes"
                src="<?php echo $rutaImgs?>defecto.png"
                alt="sep"
              />
            </a>
          </aside>
        </section>
        <section class="d-flex row pt-2 align-items-center">
          <aside class="col-sm-12 col-md-6 col-lg-3 text-center mt-1">
            <a
              class=""
              href="https://www.indec.gob.ar/"
              target="_blank"
              rel="noopener noreferrer"
            >
              <img
                class="img-interes"
                src="<?php echo $rutaImgs?>indec.png"
                alt="indec"
              />
            </a>
          </aside>

          <aside class="col-sm-12 col-md-6 col-lg-3 text-center mt-1">
            <a
              class=""
              href="https://digituc.gob.ar/"
              target="_blank"
              rel="noopener noreferrer"
            >
              <img
                class="img-interes"
                src="<?php echo $rutaImgs?>digituc.png"
                alt="digituc"
              />
            </a>
          </aside>

          <aside class="col-sm-12 col-md-6 col-lg-3 text-center">
            <a
              class=""
              href="http://idet.tucuman.gob.ar/"
              target="_blank"
              rel="noopener noreferrer"
            >
              <img
                class="img-interes bg-dark"
                src="<?php echo $rutaImgs?>idet.png"
                alt="idet"
              />
            </a>
          </aside>

          <aside class="col-sm-12 col-md-6 col-lg-3 text-center">
            <a
              class=""
              href="https://www.un.org/sustainabledevelopment/es/"
              target="_blank"
              rel="noopener noreferrer"
            >
              <img
                class="img-interes"
                src="<?php echo $rutaImgs?>odsFranja.png"
                alt="ods Franja"
              />
            </a>
          </aside>
        </section>
    </Section>
    </footer>
    <script src="<?php echo BASE_URL;?>styles/js/bootstrap.bundle.min.js"></script>

</body>
</html>
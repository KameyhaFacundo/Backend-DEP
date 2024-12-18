import React from "react";
import { Container, Row, Col, Card } from "react-bootstrap";
import "./footer.css";
import imgDefecto from "../../assets/sitiosImg/defecto.png";
import imgRIG from "../../assets/sitiosImg/RIG.png";
import imgIndec from "../../assets/sitiosImg/indec.png";
import imgDigituc from "../../assets/sitiosImg/digituc.png";
import imgIdet from "../../assets/sitiosImg/idet.png";
import imgOdsFranja from "../../assets/sitiosImg/odsFranja.png";

const Footer = () => {
  const handleImageError = (event) => {
    event.target.src = require("../../assets/img/picture.svg");
  };

  return (
    <footer className="bg-dark text-light pt-3">
      <Container fluid className="w-100">
        <h1 className="text-center val-round">Sitios web de interés</h1>
        <Row className="align-items-center">
          <aside className="col-sm-12 col-md-6 col-lg-3 text-center">
            <a
              className=""
              href="http://estadistica.tucuman.gov.ar/"
              target="_blank"
              rel="noopener noreferrer"
            >
              <img
                className="img-interes"
                onError={handleImageError}
                src={imgDefecto}
                alt="estadistica"
              />
            </a>
          </aside>

          <aside className="col-sm-12 col-md-6 col-lg-3 text-center mt-1">
            <a
              className=""
              href="http://planeamiento.tucuman.gob.ar/"
              target="_blank"
              rel="noopener noreferrer"
            >
              <img
                className="img-interes"
                onError={handleImageError}
                src={imgDefecto}
                alt="planeamiento"
              />
            </a>
          </aside>

          <aside className="col-sm-12 col-md-6 col-lg-3 text-center mt-1">
            <a
              className=""
              href="https://correorig.tucuman.gob.ar/"
              target="_blank"
              rel="noopener noreferrer"
            >
              <img
                className="img-interes"
                onError={handleImageError}
                src={imgRIG}
                alt="rig"
              />
            </a>
          </aside>

          <aside className="col-sm-12 col-md-6 col-lg-3 text-center mt-1">
            <a
              className=""
              href="https://sep.tucuman.gob.ar/"
              target="_blank"
              rel="noopener noreferrer"
            >
              <img
                className="img-interes"
                onError={handleImageError}
                src={imgDefecto}
                alt="sep"
              />
            </a>
          </aside>
        </Row>
        <Row className="pt-2 align-items-center">
          <aside className="col-sm-12 col-md-6 col-lg-3 text-center mt-1">
            <a
              className=""
              href="https://www.indec.gob.ar/"
              target="_blank"
              rel="noopener noreferrer"
            >
              <img
                className="img-interes"
                onError={handleImageError}
                src={imgIndec}
                alt="indec"
              />
            </a>
          </aside>

          <aside className="col-sm-12 col-md-6 col-lg-3 text-center mt-1">
            <a
              className=""
              href="https://digituc.gob.ar/"
              target="_blank"
              rel="noopener noreferrer"
            >
              <img
                className="img-interes"
                onError={handleImageError}
                src={imgDigituc}
                alt="digituc"
              />
            </a>
          </aside>

          <aside className="col-sm-12 col-md-6 col-lg-3 text-center">
            <a
              className=""
              href="http://idet.tucuman.gob.ar/"
              target="_blank"
              rel="noopener noreferrer"
            >
              <img
                className="img-interes bg-dark"
                onError={handleImageError}
                src={imgIdet}
                alt="idet"
              />
            </a>
          </aside>

          <aside className="col-sm-12 col-md-6 col-lg-3 text-center">
            <a
              className=""
              href="https://www.un.org/sustainabledevelopment/es/"
              target="_blank"
              rel="noopener noreferrer"
            >
              <img
                className="img-interes"
                onError={handleImageError}
                src={imgOdsFranja}
                alt="ods Franja"
              />
            </a>
          </aside>
        </Row>
      </Container>
    </footer>
  );
};

export default Footer;

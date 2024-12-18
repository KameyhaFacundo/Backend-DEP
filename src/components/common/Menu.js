import React from "react";
import { Container, Navbar } from "react-bootstrap";
import { Link, useNavigate } from "react-router-dom";
import logoNavbar from "../../assets/img/header.jpg";
import logoNavbarResponsive from "../../assets/img/header-responsive-SM.png";

const Menu = () => {
  const usuarioLogueado = JSON.parse(sessionStorage.getItem('user')) || null;
  let link = '/';
  if(usuarioLogueado)
  {
    link = '/home/';
  }
    return (
      <Navbar expand="lg" className="bg-body-tertiary">
        <Container className='mt-0'>
          <Navbar.Brand as={Link} to={link} className='d-flex justify-content-center d-xl-block d-md-none'>
            <img src={logoNavbar} alt="Direccion Estadistica de la provincia de Tucuman" className='logo-navbar w-100' />
          </Navbar.Brand>
          <Navbar.Brand as={Link} to={link} className='d-flex justify-content-center d-none d-md-block d-sm-block d-xl-none'>
            <img src={logoNavbarResponsive} alt="Direccion Estadistica de la provincia de Tucuman" className='logo-navbar w-100' />
          </Navbar.Brand>
        </Container>
    </Navbar>
  );
};

export default Menu;

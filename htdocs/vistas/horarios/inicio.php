<?php 
	session_start();
	if(isset($_SESSION['usuario'])){
		
 ?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../css/personal.css">
	<title>inicio</title>
	<?php require_once "menu.php"; ?>

</head>
<body>


<a href="Codigos/codigos.php" target="_black">Codigos</a>



<div  class="container shadow-lg p-3 mb-5 mt-5 bg-body rounded">
        <div  style="border:none; text-align: center;" class="row">
            <div class="col">
                <table   id="myTable" class="table table-striped" style="width:100%; ">
                   <thead><tr style="background-color: #c4c2c2;  border:1px solid black;" class="tableizer-firstrow" ><th style="text-align: center; color: black;  border:1px solid black; ">CÓDIGOS SERVICIOS</th><th style="text-align: center; color: black;  border:1px solid black;" >CEDULA</th><th style="text-align: center; color: black;  border:1px solid black;">APELLIDO</th><th style="color: black;  border:1px solid black; text-align: center;">NOMBRE</th><th style="text-align: center; color: black; color: black; border:1px solid black;">CARGO</th><th style="text-align: center; color: black;  border:1px solid black;"> CENTRO</th></tr></thead><tbody>
 <tr><td>1</td><td>6.100.540</td><td>ANDARA</td><td>ELENA</td><td>ALMACENISTA II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>2</td><td>10.115.652</td><td>CAMACARO</td><td>JORGE</td><td>ALMACENISTA II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>3</td><td>16.627.392</td><td>VALDERRAMA</td><td>MAIRA</td><td>ALMACENISTA II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>4</td><td>17.080.111</td><td>TORO</td><td>JOSE</td><td>ASISTENTE  ADMINISTRATIVO III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>5</td><td>15.986.652</td><td>GARCIA</td><td>YESENIA</td><td>ASISTENTE  ADMINISTRATIVO III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>6</td><td>10.745.641</td><td>MORENO</td><td>NANCY</td><td>ASISTENTE  ADMINISTRATIVO III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>7</td><td>15.605.583</td><td>BRICEÑO</td><td>MARY CARMEN</td><td>ASISTENTE  ADMINISTRATIVO III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>8</td><td>11.200.791</td><td>ALVARADO</td><td>YANETH</td><td>ASISTENTE  ADMINISTRATIVO III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>9</td><td>6.360.293</td><td>MARTINEZ</td><td>LENNY</td><td>ASISTENTE  ADMINISTRATIVO III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>10</td><td>20.096.415</td><td>MARTINEZ</td><td>SHERYL</td><td>ASISTENTE  ADMINISTRATIVO III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>11</td><td>11.675.375</td><td>ORTIZ</td><td>SOLANGE</td><td>ASISTENTE  ADMINISTRATIVO IV</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>12</td><td>16.331.545</td><td>TORRES</td><td>MAIGUALIDA</td><td>ASISTENTE  ADMINISTRATIVO IV</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>13</td><td>9.221.694</td><td>VASQUEZ</td><td>GERMAN</td><td>ASISTENTE  ADMINISTRATIVO IV</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>14</td><td>16.900.810</td><td>HERNANDEZ</td><td>DAYMAR</td><td>ASISTENTE  ADMINISTRATIVO IV</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>15</td><td>14.195.624</td><td>COLMENARES</td><td>MARTHA</td><td>ASISTENTE  ADMINISTRATIVO IV</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>16</td><td>13.432.060</td><td>VASQUEZ</td><td>YANITZA</td><td>ASISTENTE  ADMINISTRATIVO V</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>17</td><td>11.940.553</td><td>CORONADO</td><td>CARLA</td><td>ASISTENTE  ADMINISTRATIVO V</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>18</td><td>6.342.283</td><td>COLMENARES</td><td>CARMEN</td><td>ASISTENTE  ADMINISTRATIVO V</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>19</td><td>28.444.622</td><td>ALGARA</td><td>KEIDY</td><td>ASISTENTE DE ANALISTA III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>20</td><td>11.944.839</td><td>AZUAJE</td><td>SOLANYER</td><td>CONTADOR I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>21</td><td>6.254.982</td><td>LUCENA</td><td>LUCECITA</td><td>SECRETARIO EJECUTIVO II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>22</td><td>14.721.048</td><td>ORTEGA</td><td>KATOUSCHA</td><td>SECRETARIO EJECUTIVO II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>23</td><td>21.438.410</td><td>ALBORNOZ</td><td>EMELY</td><td>SECRETARIO EJECUTIVO II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>24</td><td>10.828.312</td><td>RUDA</td><td>AYDE</td><td>SECRETARIO EJECUTIVO III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>25</td><td>27.569.533</td><td>MORA</td><td>ADRIAN</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>26</td><td>29.720.306</td><td>NAVA</td><td>JOHANDRY</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>27</td><td>6.032.401</td><td>NUÑEZ</td><td>LEIDY</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>28</td><td>13.583.646</td><td>RIVAS</td><td>MAJAUYURI</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>29</td><td>17.476.834</td><td>CORTEZ</td><td>JENNIFER</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>30</td><td>30.990.409</td><td>CACERES</td><td>JEANOSKY</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>31</td><td>24.203.903</td><td>GONZALEZ</td><td>FRANCYS</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>32</td><td>17.693.559</td><td>MANCHEGO</td><td>LEIDY</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>33</td><td>19.153.419</td><td>PAREDES</td><td>JESUS</td><td>MEDICO I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>34</td><td>20.630.942</td><td>SIMANCA</td><td>NORVYS</td><td>MEDICO I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>35</td><td>15.738.450</td><td>SIMANCAS</td><td>LISETH</td><td>MEDICO I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>36</td><td>16.233.432</td><td>VARGAS DE</td><td>CARMEN</td><td>MEDICO I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>37</td><td>4.577.781</td><td>MAIZO</td><td>CESAR</td><td>MEDICO II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>38</td><td>6.687.225</td><td>RANGEL</td><td>AIDEE</td><td>MEDICO II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>39</td><td>5.892.040</td><td>NOTARANDREA</td><td>MARIA</td><td>MEDICO II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>40</td><td>10.380.294</td><td>CARMONA</td><td>VIRGINIA</td><td>ODONTOLOGO II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>41</td><td>5.431.836</td><td>OMAÑA</td><td>OMAIRA</td><td>ODONTOLOGO III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>42</td><td>12.378.697</td><td>ALVAREZ</td><td>LISBETH</td><td>MEDICO ESPECIALISTA I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>43</td><td>10.719.571</td><td>GOTTBERG</td><td>OLGA</td><td>MEDICO ESPECIALISTA II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>44</td><td>6.525.210</td><td>VILLEGAS</td><td>OSWALDO</td><td>MEDICO ESPECIALISTA II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>45</td><td>12.591.074</td><td>GODOY</td><td>JONELLY</td><td>MEDICO ADJUNTO II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>46</td><td>6.861.966</td><td>HERRADA</td><td>CESAR</td><td>MEDICO ESPECIALISTA I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>47</td><td>7.560.869</td><td>LEAL</td><td>RAFAEL</td><td>MEDICO ESPECIALISTA II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>48</td><td>8.532.594</td><td>REAL</td><td>FRANCIA</td><td>MEDICO ESPECIALISTA II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>49</td><td>3.969.416</td><td>PEREZ</td><td>MARIA</td><td>MEDICO ESPECIALISTA II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>50</td><td>5.426.691</td><td>BERMUDEZ</td><td>JUAN</td><td>MEDICO ESPECIALISTA II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>51</td><td>3.626.870</td><td>VIVAS</td><td>ALBERTO</td><td>MEDICO ESPECIALISTA II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>52</td><td>4.251.980</td><td>RAMIREZ</td><td>ANGEL</td><td>MEDICO ESPECIALISTA II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>53</td><td>5.218.258</td><td>LAU</td><td>MAGDALENA</td><td>MEDICO ESPECIALISTA II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>54</td><td>15.928.657</td><td>MENDOZA</td><td>ZULAY</td><td>ASISTENTE DE FARMACIA I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>55</td><td>11.692.904</td><td>CASTRO</td><td>ACNERYS</td><td>ASISTENTE DE FARMACIA II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>56</td><td>10.809.540</td><td>GONZALEZ</td><td>RIGOBERTO</td><td>ASISTENTE DE FARMACIA II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>57</td><td>8.694.338</td><td>SANTAELLA</td><td>CRUZ</td><td>ASISTENTE DE FARMACIA II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>58</td><td>10.528.062</td><td>VILLAMIZAR</td><td>SOLYMAR</td><td>ASISTENTE DE FARMACIA II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>59</td><td>16.023.152</td><td>BRITO</td><td>RICHARD</td><td>AYUDANTE DE ALMACEN</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>60</td><td>13.969.420</td><td>VILLALBA</td><td>YELITZA</td><td>ASISTENTE DE LABORATORIO CLINICO I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>61</td><td>6.296.074</td><td>GIL</td><td>LUIS</td><td>ASISTENTE DE LABORATORIO CLINICO II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>62</td><td>24.940.807</td><td>SILVA</td><td>MARIA</td><td>ASISTENTE DE LABORATORIO CLINICO II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>63</td><td>18.222.507</td><td>QUINTERO</td><td>ILENNY</td><td>ASISTENTE DE LABORATORIO CLINICO II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>64</td><td>20.827.435</td><td>BRICENO</td><td>NORJEISY</td><td>AUXILIAR DE LABORATORIO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>65</td><td>22.522.302</td><td>DIAZ</td><td>YOCCY</td><td>RECEPCIONISTA</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>66</td><td>26.279.109</td><td>FIGUEREDO</td><td>MAIREG</td><td>RECEPCIONISTA</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>67</td><td>12.061.087</td><td>BRITO</td><td>ROSA</td><td>CAMARERA</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>68</td><td>14.675.919</td><td>LOPEZ</td><td>MARVIN</td><td>CAMARERA</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>69</td><td>15.928.406</td><td>NUÑEZ</td><td>SOLXIRE</td><td>CAMARERA</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>70</td><td>19.689.843</td><td>BOLIVAR</td><td>ANNYS</td><td>CAMARERA</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>71</td><td>12.820.519</td><td>NARVAEZ</td><td>MIROSLABA</td><td>CAMARERA</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>72</td><td>15.313.278</td><td>PERAZA</td><td>JESUS</td><td>CAMILLERO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>73</td><td>20.606.620</td><td>PEREZ</td><td>ROSANA</td><td>ENFERMERA(O) I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>74</td><td>14.017.800</td><td>SILVA</td><td>ROXI</td><td>ENFERMERA(O) I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>75</td><td>16.028.028</td><td>CABAÑA</td><td>YOLIMAR</td><td>ENFERMERA(O) I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>76</td><td>26.994.288</td><td>MONTERO</td><td>DOANY</td><td>ENFERMERA(O) I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>77</td><td>22.748.017</td><td>VASQUEZ</td><td>KATHERINE</td><td>ENFERMERA(O) I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>78</td><td>17.390.583</td><td>AMARO</td><td>RAQUEL</td><td>ENFERMERA(O) II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>79</td><td>15.930.086</td><td>IRISA</td><td>RUTH</td><td>ENFERMERA(O) II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>80</td><td>17.478.184</td><td>PEREZ</td><td>KEYLA</td><td>ENFERMERA(O) II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>81</td><td>13.463.217</td><td>REYES</td><td>YRIANTHANAIS</td><td>ENFERMERA(O) II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>82</td><td>17.100.646</td><td>SILVA</td><td>CARMEN</td><td>ENFERMERA(O) II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>83</td><td>15.421.101</td><td>TREJO</td><td>LEYDA</td><td>ENFERMERA(O) II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>84</td><td>16.662.418</td><td>CASTRO</td><td>YORLIN</td><td>ENFERMERA(O) II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>85</td><td>12.861.132</td><td>GERVIS</td><td>NAIROVIS</td><td>ENFERMERA(O) II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>86</td><td>12.112.517</td><td>RANGEL</td><td>LAURA</td><td>ENFERMERA(O) II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>87</td><td>12.418.096</td><td>RANGEL</td><td>GREGORI</td><td>ENFERMERA(O) II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>88</td><td>15.186.873</td><td>CASTILLO</td><td>YOLANI</td><td>ENFERMERA(O) II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>89</td><td>13.888.724</td><td>PORTILLA</td><td>YULY</td><td>ENFERMERA(O) II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>90</td><td>15.793.476</td><td>SULBARAN</td><td>SOLIANNY</td><td>ENFERMERA(O) II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>91</td><td>13.088.009</td><td>HERNANDEZ</td><td>DAYANA</td><td>ENFERMERA(O) II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>92</td><td>12.112.334</td><td>BARRIENTOS</td><td>YOLIMAR</td><td>ENFERMERA(O) II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>93</td><td>11.932.378</td><td>VEGA</td><td>MARIBEL</td><td>ENFERMERA(O) III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>94</td><td>14.584.744</td><td>BRAVO</td><td>VIANEY</td><td>ENFERMERA(O) III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>95</td><td>12.295.551</td><td>LOPEZ</td><td>EURIDICE</td><td>ENFERMERA(O) III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>96</td><td>16.265.019</td><td>GARCIA</td><td>YUNEIKA</td><td>ENFERMERA(O) III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>97</td><td>10.398.382</td><td>LOZADA</td><td>ENA</td><td>ENFERMERA(O) III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>98</td><td>9.172.578</td><td>LOZADA</td><td>IRIA</td><td>ENFERMERA(O) III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>99</td><td>6.728.071</td><td>MENDEZ</td><td>YUMARI</td><td>ENFERMERA(O) III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>100</td><td>10.239.643</td><td>CHOURIO</td><td>MARIA</td><td>ENFERMERA(O) III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>101</td><td>15.343.391</td><td>FUENTES</td><td>ROCIO</td><td>ENFERMERA(O) III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>102</td><td>17.556.457</td><td>QUEVEDO</td><td>NORELKIS</td><td>ENFERMERA(O) III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>103</td><td>14.277.969</td><td>CASTILLO</td><td>YELITZA</td><td>ENFERMERA(O) III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>104</td><td>12.419.356</td><td>GONZALEZ</td><td>TERESA</td><td>ENFERMERA(O) III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>105</td><td>15.421.595</td><td>MONTILLA</td><td>FRANCIS</td><td>ENFERMERA(O) III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>106</td><td>13.253.354</td><td>SULBARAN</td><td>YOLI</td><td>ENFERMERA(O) III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>107</td><td>9.954.268</td><td>CHANGAROTTI</td><td>YAJAIRA</td><td>ENFERMERA(O) III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>108</td><td>6.035.636</td><td>VELASCO</td><td>GLADYS</td><td>ENFERMERA(O) IV</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>109</td><td>10.224.368</td><td>GOMEZ</td><td>MILAGROS</td><td>HIGIENISTA DENTAL I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>110</td><td>17.390.847</td><td>LOPEZ</td><td>CERLIN</td><td>HIGIENISTA DENTAL II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>111</td><td>6.450.856</td><td>PEREIRA</td><td>MARYELY</td><td>TECNICO RADIOLOGO II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>112</td><td>6.730.383</td><td>ABACHE</td><td>JOSE</td><td>TECNICO RADIOLOGO III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>113</td><td>14.547.215</td><td>HERRERA</td><td>MARIA</td><td>TECNICO RADIOLOGO III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>114</td><td>12.375.256</td><td>CASTILLO</td><td>JOSE</td><td>TECNICO RADIOLOGO IV</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>115</td><td>22.918.241</td><td>JIMENEZ</td><td>YOLIMAR</td><td>TERAPEUTA OCUPACIONAL III</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>116</td><td>26.838.763</td><td>GOMEZ</td><td>ANGIE</td><td>ASISTENTE EN INFORMACION Y ESTADISTICA DE SALUD I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>117</td><td>18.030.756</td><td>COLINA</td><td>LUZ</td><td>ASISTENTE EN INFORMACION Y ESTADISTICA DE SALUD I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>118</td><td>22.028.543</td><td>MONTILLA</td><td>ROUSELIS</td><td>ASISTENTE EN INFORMACION Y ESTADISTICA DE SALUD I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>119</td><td>15.788.347</td><td>FARIAS</td><td>YUSMARY</td><td>ASISTENTE EN INFORMACION Y ESTADISTICA DE SALUD II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>120</td><td>7.926.926</td><td>COLLADO</td><td>EVELYSSE</td><td>ASISTENTE EN INFORMACION Y ESTADISTICA DE SALUD II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>121</td><td>11.198.437</td><td>ARRECHEDERA</td><td>ALEJANDRA</td><td>ASISTENTE EN INFORMACION Y ESTADISTICA DE SALUD II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>122</td><td>14.454.612</td><td>GARCIA</td><td>ABELICIA</td><td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>123</td><td>6.203.067</td><td>SANCHEZ</td><td>SONIA</td><td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>124</td><td>13.395.270</td><td>SEGOVIA</td><td>CAROLINA</td><td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>125</td><td>14.875.370</td><td>ZORRILLA</td><td>WENDY</td><td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>126</td><td>13.851.822</td><td>BRITO</td><td>HEIDI</td><td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>127</td><td>16.856.053</td><td>MEJIAS</td><td>MARIA</td><td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>128</td><td>11.935.797</td><td>AGUILAR</td><td>LELLYMAR</td><td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>129</td><td>15.421.608</td><td>PENALVER</td><td>DUBIA</td><td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>130</td><td>12.957.466</td><td>MARQUINAS</td><td>LILIANA</td><td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>131</td><td>21.172.391</td><td>RODRIGUEZ</td><td>ELIANA</td><td>TECNICO EN INFORMACION Y ESTADISTICA DE SALUD II</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>132</td><td>24.901.864</td><td>BARAONES</td><td>GENESIS</td><td>ASEADOR</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>133</td><td>20.098.724</td><td>OLIVARES</td><td>FRANCIS</td><td>ASEADOR</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>134</td><td>17.563.610</td><td>SALAZAR</td><td>OSCAR</td><td>AYUDANTE DE SERVICIOS  GENERALES</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>135</td><td>6.122.480</td><td>RIVAS</td><td>WALDO</td><td>CHOFER DE TRANSPORTE</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>136</td><td>12.115.405</td><td>SEPULVEDA</td><td>GERALD</td><td>TECNICO DE REPARACION Y MANTENIMIENTO  I</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>137</td><td>4.140.621</td><td>DIAZ</td><td>CARMEN</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>138</td><td>27.333.797</td><td>NIÑO</td><td>ROSMARY</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>139</td><td>12.377.132</td><td>AVILA</td><td>LUISA</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>140</td><td>25.215.458</td><td>BRITO</td><td>KEILIMAR</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>141</td><td>6.462.147</td><td>LOPEZ</td><td>LEONOR</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>142</td><td>15.039.518</td><td>RIVAS</td><td>JOHANNA</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>143</td><td>5.070.819</td><td>BEOMON</td><td>ALIS</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>144</td><td>12.282.196</td><td>GAINZA</td><td>LISBEH</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>145</td><td>10.804.152</td><td>GARCIA</td><td>DANELYS</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>146</td><td>11.944.505</td><td>GARCIA</td><td>LISBETH</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>147</td><td>16.030.049</td><td>OSORIO</td><td>ROSMERI</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>148</td><td>7.942.818</td><td>PINEDA</td><td>ZAIDA</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>149</td><td>13.457.920</td><td>CANACHE</td><td>ROSANGEL</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>150</td><td>14.421.737</td><td>FUENTES</td><td>MARIANELA</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>151</td><td>10.814.064</td><td>MACHADO</td><td>YENNIFER</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>152</td><td>6.446.373</td><td>ROSALES</td><td>ADEL</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>153</td><td>17.266.267</td><td>ROSALES</td><td>DENIS</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>154</td><td>12.418.981</td><td>SANCHEZ</td><td>FRANCIS</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>155</td><td>12.772.778</td><td>ESCALONA</td><td>ELIA</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>156</td><td>16.021.376</td><td>GONZALEZ</td><td>ANA</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>157</td><td>14.535.054</td><td>GONZALEZ</td><td>MARY</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>158</td><td>22.880.147</td><td>MANRIQUE</td><td>YACKELIN</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>159</td><td>10.693.236</td><td>MARTINEZ</td><td>JOSE</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>160</td><td>11.916.412</td><td>MARTINEZ</td><td>JOSE</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>161</td><td>17.974.607</td><td>MELENDEZ</td><td>LISMARI</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>162</td><td>6.061.434</td><td>MONTILLA</td><td>JOSE</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>163</td><td>4.834.825</td><td>PALACIOS</td><td>MARISOL</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>164</td><td>9.097.828</td><td>HENRIQUEZ</td><td>WILLIAM</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>165</td><td>14.471.502</td><td>HENRIQUEZ</td><td>NORELKIS</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>166</td><td>12.292.520</td><td>HERNANDEZ</td><td>LUZ</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>167</td><td>19.452.767</td><td>HERNANDEZ</td><td>JULIMAR</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
 <tr><td>168</td><td>31.249.385</td><td>ESPARRAGOZA</td><td>ABEL</td><td>CONTRATADO</td><td>CLINICA POPULAR TIPO I DR. ARMANDO CASTILLO PLAZA</td></tr>
</tbody></table>          
            
            </div>
        </div>
    </div>

 

 <!-- jquery y bootstrap -->
 <script src="https://code.jquery.com/jquery-3.5.1.js"></script>   
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
 
 <!-- datatables con bootstrap -->
 <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>	
 <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>

 <!-- Para usar los botones -->
 <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>


<!-- Para los estilos en Excel     -->
<script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.1/js/buttons.html5.styles.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.1/js/buttons.html5.styles.templates.min.js"></script>
<script>
$(document).ready(function () {
    $("#myTable").DataTable({
        dom: "Bfrtip",
        buttons:{
            dom: {
                button: {
                    className: 'btn'
                }
            },
            buttons: [
            {
                //definimos estilos del boton de excel
                extend: "excel",
                text:'Exportar a Excel',
                className:'btn btn-outline-success',

                // 1 - ejemplo básico - uso de templates pre-definidos
                //definimos los parametros al exportar a excel
                
                excelStyles: {                
                    //template: "header_blue",  // Apply the 'header_blue' template part (white font on a blue background in the header/footer)
                    //template:"green_medium" 
                    
                    "template": [
                        "blue_medium",
                        "header_green",
                        "title_medium"
                    ] 
                    
                },
                
 

            }
            ]            
        }            
    });
});
    </script>





</body>
</html>
<?php 
	}else{
		header("location:../index.php");
	}
 ?>
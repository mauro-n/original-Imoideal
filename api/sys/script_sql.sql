CREATE TABLE IF NOT EXISTS T_USER (
	USR_ICOD     VARCHAR(14) NOT NULL, #Codigo Interno Usuario AAAAMMDDHHMMSS
	
    #Dados Cliente#
    USR_EMAL     VARCHAR(100) NOT NULL, #Email
    USR_KBOT     VARCHAR(50), #Chave para APIs
	USR_PASS     VARCHAR(150) NOT NULL, #Senha
    USR_IMGP     VARCHAR(150) NOT NULL, #Imagem Perfil
    USR_NOME     VARCHAR(150) NOT NULL, #Nome
    USR_TELF     BIGINT(15) UNSIGNED, #Telefone
    USR_PLAN   	 TINYINT(1) UNSIGNED NOT NULL DEFAULT 0, #Plano 0-Gratis 1-Premiun 2-Atrasado
    
    #Campos do sistema#
    USR_STTS     TINYINT(1) UNSIGNED NOT NULL DEFAULT 0, #Status Email 0-Não confirmado
    USR_WPVF     TINYINT(1) UNSIGNED NOT NULL DEFAULT 0, #WhatsApp 0-Não Verificado
    USR_CDWP     VARCHAR(5), #Codigo Whatsapp
    USR_RSTP     TINYINT(1) UNSIGNED NOT NULL DEFAULT 0, #Reset Senha 0-Não ativo
    USR_CDPS     VARCHAR(50), #Codigo Redefinição de senha
    
    #Datas
    USR_DTC      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, #Data de Criação
    USR_DTL      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, #Data ultimo login
    USR_DTA      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, #Data da ultima Alteração
    
    PRIMARY KEY (USR_ICOD)
);
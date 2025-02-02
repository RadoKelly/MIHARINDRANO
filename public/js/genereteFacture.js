// <!-- Inclusion de jsPDF -->
// <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
// <!-- Inclusion du plugin autoTable -->
// <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>


function genererFacturePDF() {
  // Récupération de l'objet jsPDF
  const { jsPDF } = window.jspdf;
  // Création d'un document A4 en portrait, unité mm
  const doc = new jsPDF('p', 'mm', 'A4');

  // VARIABLES DYNAMIQUES (à modifier selon vos besoins)
  const entreprise         = "ENTREPRISE MIHARINDRANO";
  const adresse            = "Lot II F 291 Ambano";
  const factureMois        = "Facture de Septembre 2024";
  const reference          = "479 ABT 055";
  const compte             = "70462836";
  const client             = "Randriatsizafy Tiana Hasivololo";
  const ancien_index       = "1,000";
  const nouveau_index      = "1,000";
  const consommation       = "0,000";
  const montant            = "1 800";
  const location_compteur  = "500";
  const autres_frais       = "0";
  const total_payer        = "500";
  const date_echeance      = "18/10/2024";

  let y = 15; // Position verticale de départ

  // ===== EN-TÊTE =====
  // Nom de l'entreprise
  doc.setFont("helvetica", "bold");
  doc.setFontSize(16);
  doc.text(entreprise, 105, y, { align: "center" });
  y += 8;
  // Adresse
  doc.setFont("helvetica", "normal");
  doc.setFontSize(10);
  doc.text(adresse, 105, y, { align: "center" });
  y += 8;
  // Mois de la facture
  doc.setFont("helvetica", "bold");
  doc.setFontSize(12);
  doc.text(factureMois, 105, y, { align: "center" });
  y += 7;

  // ===== TABLEAU : INFORMATIONS GÉNÉRALES =====
  doc.setFontSize(10);
  doc.setLineWidth(0.5);
  doc.line(10, y, 200, y);
  y+=5
  
  // -- Ligne 1 : Référence et Compte N°
  doc.setFont("helvetica", "bold");
  doc.text(`Référence : ${reference}`, 15, y);
  doc.text(`Num Compteur : ${compte}`, 95, y);
  y += 6;
  doc.setFont("helvetica", "normal");
  doc.text(`client : ${client}`, 15, y);
  doc.text(`Lazam-bola : Compoteur 1`, 95, y);
  y += 5;

  // Optionnel : Dessiner une ligne de séparation horizontale
  doc.setLineWidth(0.5);
  doc.line(10, y, 200, y);
  y+=5

  // -- Ligne 3 : Ancien Index et Nouveau Index
  doc.setFont("helvetica", "bold");
  doc.text("Ancien Index", 15, y);
  doc.text("Nouveau Index", 115, y);
  y += 6;
  doc.setFont("helvetica", "normal");
  doc.text(`${ancien_index} (18/10/2024)`, 15, y);
  doc.text(`${nouveau_index} (18/10/2024)`, 115, y);
  y += 10;

  // -- Ligne 4 : Consommation (m³) et Montant (Ar)
  doc.setFont("helvetica", "bold");
  doc.text("Consommation (m³)", 15, y);
  y += 6;
  doc.setFont("helvetica", "normal");
  doc.text(consommation, 15, y);
  y += 15;

  // Optionnel : Dessiner une ligne de séparation horizontale
  doc.setLineWidth(0.5);
  doc.line(10, y, 200, y);
  y += 8;

  // ===== SECTION : FRAIS DIVERS =====
  // Titre de la section
  doc.setFont("helvetica", "bold");
  doc.setFontSize(12);
  doc.text("SARANY SAMIHAFA (Frais Divers)", 105, y, { align: "center" });
  y += 8;
  
  // -- Tableau Frais Divers : Type de frais et Montant (Ar)
  doc.setFontSize(10);
  // En-tête du tableau
  doc.setFont("helvetica", "bold");
  doc.text("Type de frais", 15, y);
  doc.text("Montant (Ar)", 115, y);
  y += 6;
  // Ligne 1 : Location Compteur
  doc.setFont("helvetica", "normal");
  doc.text("Location Compteur", 15, y);
  doc.text(location_compteur, 115, y);
  y += 6;
  // Ligne 2 : Autres Frais
  doc.text("Autres Frais", 15, y);
  doc.text(autres_frais, 115, y);
  y += 15;

  // ===== PIED DE PAGE =====
  // Total à Payer et Date d'échéance (centrés)
  doc.setFont("helvetica", "bold");
  doc.setFontSize(12);
  doc.text(`Total à Payer : ${total_payer} Ar`, 105, y, { align: "center" });
  y += 8;
  doc.text(`Date d'échéance : ${date_echeance}`, 105, y, { align: "center" });
  
  // Sauvegarder et télécharger le PDF
  doc.save("facture.pdf");
}
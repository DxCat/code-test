import React from "react";
import SQLImprovement from "../components/SQLImprovement.jsx";
import { Box, IconButton } from "@mui/joy";
import ArrowBackIcon from "@mui/icons-material/ArrowBack";
import { useNavigate } from "react-router-dom";
import { route } from "../routes/Router.jsx";

const CardPage = () => {
  const navigate = useNavigate();

  return (
    <Box
      component="main"
      sx={{
        position: "relative",
        display: "flex",
        flexDirection: "column",
        alignItems: "center",
        justifyContent: "center",
        padding: 2,
      }}
    >
      <IconButton
        onClick={() => navigate(route("home"))}
        sx={{
          position: "absolute",
          top: 16,
          left: 16,
        }}
      >
        <ArrowBackIcon /> Back
      </IconButton>

      <SQLImprovement />
    </Box>
  );
};

export default CardPage;

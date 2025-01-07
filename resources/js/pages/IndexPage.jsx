import React from "react";
import { Box, Typography, Card } from "@mui/joy";
import { Link as RouterLink } from "react-router-dom";
import { route } from "../routes/Router.jsx";

const IndexPage = () => {
  return (
    <Box
      component="main"
      sx={{
        display: "flex",
        flexDirection: "column",
        alignItems: "center",
        justifyContent: "center",
        minHeight: "100vh",
        padding: 0,
      }}
    >
      <Typography level="h1" textAlign="center" marginBottom={4}>
        Coding Test
      </Typography>

      <Box sx={{ display: "flex", flexDirection: "column", gap: 3 }}>
        <Card
          component={RouterLink}
          to={route("card")}
          sx={{
            textDecoration: "none",
            width: 300,
            color: "white",
            boxShadow: "md",
            borderRadius: "lg",
            textAlign: "center",
            padding: 2,
            "&:hover": {
              backgroundColor: "neutral.100",
            },
          }}
        >
          <Typography level="h3">Test A</Typography>
          <Typography level="body-lg" color="neutral">Programming Test</Typography>
        </Card>

        <Card
          component={RouterLink}
          to={route("sql")}
          sx={{
            textDecoration: "none",
            width: 300,
            color: "white",
            boxShadow: "md",
            borderRadius: "lg",
            textAlign: "center",
            padding: 2,
            "&:hover": {
              backgroundColor: "neutral.100",
            },
          }}
        >
          <Typography level="h3">Test B</Typography>
          <Typography level="body-lg" color="neutral">SQL Improvement Logic Test</Typography>
        </Card>
      </Box>
    </Box>
  );
};

export default IndexPage;
